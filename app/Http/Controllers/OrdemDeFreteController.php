<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdemDeFreteEmailRequest;
use App\Http\Requests\OrdemDeFreteRequest;
use App\Models\Measure;
use App\Models\Motorista;
use App\Models\OrdemDeFrete;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PDF;

class OrdemDeFreteController extends Controller
{
    public function index()
    {
        return view('ordens_frete.index');
    }

    public function create()
    {
        $ordemFrete = new OrdemDeFrete();
        $motoristas = Motorista::select(['id', 'nome'])->get();
        $measures = Measure::select(['id', 'name'])->get();

        return view('ordens_frete.edit', compact('ordemFrete', 'motoristas', 'measures'));
    }

    public function store(OrdemDeFreteRequest $request)
    {
        $data = $request->all();
        $data['data_carregamento'] = Carbon::createFromFormat('d/m/Y', $data['data_carregamento'])->format('Y-m-d');
        $data['previsao_descarga'] = Carbon::createFromFormat('d/m/Y', $data['previsao_descarga'])->format('Y-m-d');
        $ordemFrete = OrdemDeFrete::create($data);

        $ordemFrete->dadosBancarios()->create($request->get('dados_bancarios'));

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi cadastrada com sucesso.');
    }

    public function show(OrdemDeFrete $ordemFrete)
    {
        return view('ordens_frete.show', compact('ordemFrete'));
    }

    public function edit(OrdemDeFrete $ordemFrete)
    {
        $motoristas = Motorista::select(['id', 'nome'])->get();
        $measures = Measure::select(['id', 'name'])->get();

        return view('ordens_frete.edit', compact('ordemFrete', 'motoristas', 'measures'));
    }

    public function update(OrdemDeFrete $ordemFrete, OrdemDeFreteRequest $request)
    {
        $data = $request->all();
        $data['data_carregamento'] = Carbon::createFromFormat('d/m/Y', $data['data_carregamento'])->format('Y-m-d');
        $data['previsao_descarga'] = Carbon::createFromFormat('d/m/Y', $data['previsao_descarga'])->format('Y-m-d');

        $ordemFrete->update($data);
        $ordemFrete->dadosBancarios()->update($request->get('dados_bancarios'));

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi atualizada com sucesso.');
    }

    public function destroy(OrdemDeFrete $ordemFrete)
    {
        try {
            $ordemFrete->delete();
        } catch (\Exception $e) {
            Log::debug($e);

            $erro = config('constants.ERRO_PADRAO');

            return redirect(route('ordens-frete.index'))->with('error', $erro.'<br><br>Erro: '.$e->getMessage());
        }

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi removida com sucesso.');
    }

    public function tableData(Request $request)
    {
        $column = $request['order'][0]['column'];

        $ordensFrete = OrdemDeFrete::join('motoristas as m', 'ordens_de_frete.motorista_id', '=', 'm.id')
            ->join('ordens_de_frete_status as ofs', 'ordens_de_frete.status_id', '=', 'ofs.id')
            ->limit($request['length'])
            ->offset($request['start'])
            ->orderBy($request['columns'][$column]['data'], $request['order'][0]['dir'])
            ->select([
                'ordens_de_frete.id',
                'm.nome as motorista',
                'data_carregamento',
                'previsao_descarga',
                'valor_frete',
                'cidade_origem',
                'cidade_destino',
                'adiantamento',
                'saldo',
                'ofs.nome as status',
            ]);

        $search = $request['search']['value'];
        $count = OrdemDeFrete::count(['id']);

        if ($request->has('motorista_id')) {
            $count = OrdemDeFrete::where('motorista_id', $request->get('motorista_id'))->count(['id']);
            $ordensFrete = $ordensFrete->where('motorista_id', $request->get('motorista_id'));
        }

        if ($search) {
            if ($request->has('motorista_id')) {
                $ordensFrete = $ordensFrete->where(function ($query) use ($search) {
                    $query->where('cidade_origem', 'like', '%'.$search.'%')
                        ->orWhere('cidade_destino', 'like', '%'.$search.'%');
                });
            } else {
                $ordensFrete = $ordensFrete->where(function ($query) use ($search) {
                    $query->where('m.nome', 'like', '%'.$search.'%')
                        ->orWhere('cidade_origem', 'like', '%'.$search.'%')
                        ->orWhere('cidade_destino', 'like', '%'.$search.'%')
                        ->orWhere('ofs.nome', 'like', '%'.$search.'%');
                });
            }
        }

        $ordensFrete = $ordensFrete->get();

        return response()->json([
            'data'            => $ordensFrete,
            'draw'            => intval($request['draw']),
            'recordsTotal'    => intval($count),
            'recordsFiltered' => $search ? $ordensFrete->count() : intval($count),
        ]);
    }

    public function finalizar(OrdemDeFrete $ordemFrete)
    {
        $ordemFrete->update([
            'status_id' => 2,
        ]);

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi finalizada com sucesso.');
    }

    public function gerarRelatorio(OrdemDeFrete $ordemFrete)
    {
        $pdf = PDF::loadView('ordens_frete.relatorio', compact('ordemFrete'));

        return $pdf->download('Relatorio_OrdemFrete_'.$ordemFrete->id.'.pdf');

        //return view('ordens_frete.relatorio', compact('ordemFrete'));
    }

    public function enviarEmail(OrdemDeFrete $ordemFrete, OrdemDeFreteEmailRequest $request)
    {
        $email = $request->get('email');
        $user = auth()->user();
        $pdf = PDF::loadView('ordens_frete.relatorio', compact('ordemFrete'));
        $pdfPath = storage_path('temp/Relatorio_OrdemFrete_'.$ordemFrete->id.'.pdf');

        $pdf->save($pdfPath);

        Mail::send('emails.ordem_frete', compact('ordemFrete'), function ($message) use ($user, $email, $ordemFrete, $pdfPath) {
            $motorista = $ordemFrete->motorista;

            $message->from($user->email, $user->name);
            $message->to($email);
            $message->subject('Ordem de Frete');

            foreach ($motorista->documents as $documento) {
                $path = storage_path("docs/".$motorista->entityType."_{$motorista->id}/{$documento->filename}");

                $message->attach($path);
            }

            $message->attach($pdfPath);
        });

        File::delete($pdfPath);

        return response()->json(['message' => 'O e-mail foi enviado com sucesso.']);
    }
}
