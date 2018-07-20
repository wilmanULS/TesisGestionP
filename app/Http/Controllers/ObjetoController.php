<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\ObjetosAp;
use Storage;
use DB;

class ObjetoController extends Controller
{
    public function index($id)
    { //revise como parametro un request

        $idioma = DB::table('idioma')
            ->select('id', 'descripcion')
            ->distinct()
            ->get();

        $dificultad = DB::table('dificultad')
            ->select('id', 'descripcion')
            ->distinct()
            ->get();

        $formato = DB::table('formato')
            ->select('id', 'descripcion')
            ->distinct()
            ->get();

        $recursoEdu = DB::table('tipo_recurso_educativo')
            ->select('id', 'descripcion')
            ->distinct()
            ->get();


        return view("Repositorio.ingresarOA", ["recursoEdu" => $recursoEdu, "idioma" => $idioma, "dificultad" => $dificultad, "formato" => $formato, "idTema" => $id]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'titulo' => 'required',
            'descripcionG' => 'required',
            'autor1' => 'required',
            'autor2' => 'required',
            'autor3' => 'required',

        ]);

        $noticia = new ObjetosAp();
        $noticia->titulo = $request->titulo;
        $noticia->descripcionG = $request->descripcionG;
        $noticia->autor1 = $request->autor1;
        $noticia->autor2 = $request->autor3;
        $noticia->autor3 = $request->autor3;

        $metadato = $request->file('url1');
        $file_route = time() . '_' . $metadato->getClientOriginalName();
        Storage::disk('ObjetosAprendizaje')->put($file_route, file_get_contents($metadato->getRealPath()));


    }

    public function indexOA()
    {


    }

    public function saveOA(Request $request)
    {

        if ($request->isMethod('post')) {
            $idTema = $request->input('idTema');
            $titulo = $request->input('titulo');
            $descripcionG = $request->input('descripcion');
            $autor1 = $request->input('autor1');
            $autor2 = $request->input('autor2');
            $autor3 = $request->input('autor3');
            $keyword1 = $request->input('keyword1');
            $keyword2 = $request->input('keyword2');
            $keyword3 = $request->input('keyword3');
            $keyword4 = $request->input('keyword4');
            $keyword5 = $request->input('keyword5');
            $tamanio = $request->input('tamanio');
            $descripcionT = $request->input('descripcionT');
            $dificultad = $request->input('dificultad');
            $idioma = $request->input('idioma');
            $tipoRecurso = $request->input('tipoRecurso');
            $formato = $request->input('formato');
            $evalDocente = $request->input('evalDocente');
            $url1 = $request->file('file1');
            $url2 = $request->file('file2');
            $url3 = $request->file('file3');
            $url4 = $request->file('file4');
            $url5 = $request->file('file5');
            $url6 = $request->file('file6');
            $url7 = $request->file('file7');
            $url8 = $request->file('file8');
            $url9 = $request->file('file9');
            $url10 = $request->file('file10');
            $filesVector = [$url1, $url2, $url3, $url4, $url5, $url6, $url7, $url8, $url9, $url10];

            $path = "\app\ ";
            $npath = trim($path);
            $public_path = storage_path();

            for ($i = 0; $i < count($filesVector); $i++) {
                if ($filesVector[$i] != null) {
                    $files_name[] = $filesVector[$i]->getClientOriginalName();
                }
            }

            for ($i = 0; $i < count($files_name); $i++) {
                Storage::disk('local')->put($files_name[$i], File::get($filesVector[$i]));

                $urls[] = $public_path . $npath . $files_name[$i];
            }


            $saveKeywords = DB::table('keywords')
                ->insert([
                    'tag1' => $keyword1,
                    'tag2' => $keyword2,
                    'tag3' => $keyword3,
                    'tag4' => $keyword4,
                    'tag5' => $keyword5,

                ]);

            $idKeyword = DB::table('keywords')->max('id');

            $saveDescripcionT = DB::table('descripcion_tecnica')
                ->insert([
                    'tamaño' => $tamanio,
                    'descripcion' => $descripcionT,
                ]);

            $idDescripcionT = DB::table('descripcion_tecnica')->max('id');


            $saveObjeto = DB::table('objetos_aprendizaje')
                ->insert([
                    'titulo' => $titulo,
                    'descripcion' => $descripcionG,
                    'autor1' => $autor1,
                    'autor2' => $autor2,
                    'autor3' => $autor3,
                    'estado' => 'activo',
                    'kw_id' => $idKeyword,
                    'evaluacion_profesor' => $evalDocente,
                    'dt_id' => $idDescripcionT,
                    'nd_id' => $dificultad,
                    'tr_id' => $tipoRecurso,
                    'id_idioma' => $idioma,
                    'cf_id' => $formato,
                    'tema_id' => $idTema,

                ]);
            $idOA = DB::table('objetos_aprendizaje')->max('id');

            for ($i = 0; $i < count($urls); $i++) {
                $saveMetadato = DB::table('metadatos')
                    ->insert([
                        'ruta' => $urls[$i],
                        'oa_id' => $idOA
                    ]);
            }
        }

    }
}
