<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Disciplina extends Controller
{

    function index()
    {


        $disciplina = DB::select('select * FROM disciplina d,  prof__disciplina pd WHERE d.id = pd.disciplina_id AND pd.prof__utilizador_id = :id', ['id' => session('utilizador')['id']]);


        if (!empty($disciplina)) {
            return view('/prof/dashboard', ['disciplinas' => $disciplina]);
        } else {
            return view('/prof/dashboard', ['disciplinas' => []]);
        }


    }

    function indexAluno()
    {


        $disciplina = DB::select('select * FROM disciplina d, disciplina_aluno pd WHERE d.id = pd.disciplina_id AND pd.aluno_utilizador_id = :id', ['id' => session('utilizador')['id']]);


        if (!empty($disciplina)) {
            return view('/aluno/dashboard', ['disciplinas' => $disciplina]);
        } else {
            return view('/aluno/dashboard', ['disciplinas' => []]);
        }


    }


    function EnterDiscProf(Request $request)
    {

        $disciplina = \App\Models\Disciplina::find($request->token);
//        $disciplina2 = DB::select('select * FROM disciplina
//                                    WHERE id = :id', ['id' => $request->token]);

        $topico = DB::select('select * FROM topicos
                                    WHERE disciplina_id = :id', ['id' => $request->token]);
        $request->session()->put('disciplina', $disciplina);

        if (!empty($topico)) {
            return view('/prof/Disciplina', ['topico' => $topico]);
        } else {
            return view('/prof/Disciplina', ['topico' => []]);
        }


    }

    function EnterDiscAluno(Request $request)
    {

        $disciplina = \App\Models\Disciplina::find($request->token);
        $quizz = DB::select('select * FROM quizz
                                    WHERE disciplina_id = :id', ['id' => $request->token]);

        $request->session()->put('disciplina', $disciplina);
        if (!empty($quizz)) {
            return view('/aluno/AlunoDisciplina', ['quizz' => $quizz]);
        } else {
            return view('/aluno/AlunoDisciplina', ['quizz' => []]);
        }


    }

    function addDisciplina(Request $request)
    {

        $id = $request->disciplina;
        try {

            $insert_disciplina = DB::insert('insert into disciplina_aluno (disciplina_id, aluno_utilizador_id) values (?,?)'
                , [$id, session('utilizador')['id']]);

            DB::select('UPDATE disciplina set inscritos=inscritos+1
            WHERE id = :id', [$id]);

            $disciplina = DB::select('select * FROM disciplina d, disciplina_aluno pd WHERE d.id = pd.disciplina_id AND pd.aluno_utilizador_id = :id', ['id' => session('utilizador')['id']]);

            if ($insert_disciplina) {
                return response()->json([
                    'message' => $disciplina,
                ]);
            } else {
                return response()->json([
                    'message' => 'erro',
                ]);
            }


        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'erro',
            ]);
        }

    }

    function create(Request $request)
    {


        $id = uniqid();
        $nome_disciplina = $request->input('disciplina');
        $descricao = $request->input('descricao');
//        $presenca = $request->input('presenca');

        $insert_disciplina = DB::insert('insert into disciplina (id, nome,descricao,inscritos) values (?,?,?,?)'
            , [$id, $nome_disciplina, $descricao, 0]);

        $insert_prof_disciplina = DB::insert('insert into prof__disciplina (prof__utilizador_id, disciplina_id) values (?,?)'
            , [session('utilizador')['id'], $id]);


        $disciplina = DB::select('select * FROM disciplina d,  prof__disciplina pd WHERE d.id = pd.disciplina_id AND pd.prof__utilizador_id = :id', ['id' => session('utilizador')['id']]);


        if ($insert_disciplina && $insert_prof_disciplina) {
            return response()->json([
                'message' => $disciplina,
            ]);
        } else {
            return response()->json([
                'message' => 'erro',
            ]);
        }

    }

    function getAlunos(Request $request)
    {

        $id = $request->id;

        $alunos = DB::select('SELECT u.id,u.nome,u.email,u.sexo
             FROM disciplina d,utilizador u,aluno a ,disciplina_aluno dp
             WHERE  a.utilizador_id=u.id
            AND  dp.aluno_utilizador_id=u.id
            AND dp.disciplina_id=d.id
            and d.id=:id', ['id' => $id]);

        if (!empty($alunos)) {
            return response()->json([
                'message' => $alunos,
            ]);
        } else {
            return response()->json([
                'message' => [],
            ]);
        }


    }

    function destroy(Request $request){

        if (session()->get('utilizador')['tipo'] == 'prof'){

            DB::statement('call deleteDisciplina(?)',[$request->id]);

            $disciplina = DB::select('select * FROM disciplina d,  prof__disciplina pd WHERE d.id = pd.disciplina_id AND pd.prof__utilizador_id = :id', ['id' => session('utilizador')['id']]);
            return response()->json([
                'message' => $disciplina,
            ]);

        }elseif (session()->get('utilizador')['tipo'] == 'aluno'){

            DB::statement('delete from disciplina_aluno where disciplina_id = ? and aluno_utilizador_id = ?',[$request->id, session('utilizador')['id']]);
            $disciplina = DB::select('select * FROM disciplina d, disciplina_aluno pd WHERE d.id = pd.disciplina_id AND pd.aluno_utilizador_id = :id', ['id' => session('utilizador')['id']]);

            return response()->json([
                'message' => $disciplina,
            ]);

        }

        return response()->json([
            'message' => 'erro',
        ]);


    }

    function editar(Request $request){


        DB::table('disciplina')
            ->where('id','=',$request->input('id'))
            ->update(['nome' => $request->input('disciplina'), 'descricao' => $request->input('descricao')]);

        return response()->json([
            'message' => 'sucesso',
        ]);

    }

    public function sucesso(Request $request){
       // dd(session('disciplina')['id']);
        $disciplina = \App\Models\Disciplina::find(session('disciplina')['id']);
        $topico = DB::select('select * FROM topicos
                                    WHERE disciplina_id = :id', ['id' => session('disciplina')['id']]);

        session()->put('disciplina', $disciplina);
        if (!empty($topico)) {
            return redirect('/prof/Disciplina/' . session('disciplina')['id'])->with('estado', 'sucesso');
        } else {
            return redirect('/prof/Disciplina' . session('disciplina')['id'])->with('estado', 'sucesso');
        }
    }

}
