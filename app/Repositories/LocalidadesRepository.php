<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\municipios;
use App\Models\estados;
use App\Models\localidades;
class LocalidadesRepository{

    public function addLocalidades($request)
    {
        //Aqui recibe el request que contiene el excell
        if ($request->file('excel') != null) {
            try {
                //Una vez echa la validacion donde el excel no sea null obtiene el tipo de archivo
                $mime = $request->file('excel')->getMimeType();
                //obtiene el nombre del archivo original
                $nameOriginal = $request->file('excel')->getClientOriginalName();
                //la extension del archivo
                $ext = $request->file('excel')->getClientOriginalExtension();
                //este dato lo hice como una simulacion en caso de que un usuario insertara  se guardaria su ID
                $user = 1;
                //la variable que contiene la carpeta dentro del api donde se guardara el archivo
                $path = public_path('archivos');
                //el nombre con el cual sera guardado el archivo combinando las variables anteriores
                $nameFile = strval($user) . '_' . strval(date('Y_m_d__H_i_s.')) . $ext;
                //Una vez guardado el nombre se manda a la carpeta con el nuevo nombre asignado del archivo
                $request->file('excel')->move($path, $nameFile);

                //Aqui se hace uso de una libreria para leer el archivo excell y mandandolo a traer de la carpeta donde se guardo con su nombre
                $book = \PhpOffice\PhpSpreadsheet\IOFactory::load($path . '/' . $nameFile);
                //en este apartado se utiliza para la lectura del excell activandola
                $sheet = $book->getActiveSheet();
                //en este apartado solo se usa para obtener el numero de columnas
                $totalRows = $sheet->getCellCollection()->getHighestRow();
                
                //Se inicia la transaccion
                DB::beginTransaction();
                //en este for se utiliza para la lectura del excell apartir de la columna de abajo de momento solo de pedi que leea apartir de la 2 columna hacia abajo hasta la numero 19 esto para que la lectura fuera un poco mas rapido el insertado
                for ($i = 2; $i <= 19; $i++) {
                    //aqui hace la validacion donde le dice que si la columna A es diferente de null continue con el insertado de datos
                    if ($sheet->getCell("A" . $i)->getValue() != null) {
                        //De acuerdo a la columna A a la O leera los datos y se guardaran en un variable para despues insertarlo
                        $d_codigo = $sheet->getCell("A" . $i)->getValue();
                        $d_asenta = $sheet->getCell("B" . $i)->getValue();
                        $d_tipo_asenta = $sheet->getCell("C" . $i)->getValue();
                        $municipio = $sheet->getCell("D" . $i)->getValue();
                        $estado = $sheet->getCell("E" . $i)->getValue();
                        $d_ciudad = $sheet->getCell("F" . $i)->getValue();
                        $cod_postal = $sheet->getCell("G" . $i)->getValue();
                        $cod_estado = $sheet->getCell("H" . $i)->getValue();
                        $c_oficina = $sheet->getCell("I" . $i)->getValue();
                        $c_cp = $sheet->getCell("J" . $i)->getValue();
                        $c_tipo_asenta = $sheet->getCell("K" . $i)->getValue();
                        $c_mnpio = $sheet->getCell("L" . $i)->getValue();
                        $id_asenta = $sheet->getCell("M" . $i)->getValue();
                        $d_zona = $sheet->getCell("N" . $i)->getValue();
                        $claveciudad = $sheet->getCell("O" . $i)->getValue();

                        //Esta variable la utilice para mejorar un poco el procesamiento de datos ya que era un poco tardado debido al  archivo que es pesado y eso hace que el proceso sea un poco lento
                        $datos = [
                            'cod_estado' => $cod_estado,
                            'estado' => $estado,
                            'c_mnpio' => $c_mnpio,
                            'municipio' => $municipio,
                            'id_asenta' => $id_asenta,
                            'd_tipo_asenta' => $d_tipo_asenta,
                            'd_asenta' => $d_asenta,
                            'cod_postal' => $cod_postal,
                            'd_codigo' => $d_codigo,
                            'd_ciudad' => $d_ciudad,
                            'c_oficina' => $c_oficina,
                            'd_zona' => $d_zona,
                            'c_tipo_asenta' => $c_tipo_asenta,
                            'claveciudad' => $claveciudad,
                        ];

                        //apartir de esta linea hasta la 107 comienza el insertado de los datos obtenidos del excell a las tablas de acuerdo a su modelo.
                        $estados = estados::create([
                            'cod_estado' => $datos['cod_estado'],
                            'estado' =>  $datos['estado'],
        
                        ]);
        
                        $municipios = municipios::create([
                            'c_mnpio' =>  $datos['c_mnpio'],
                            'municipio' =>  $datos['municipio'],
                            'cod_estado' => $estados->cod_estado,
                            'estados_id' => $estados->id
                        ]);
                        
                        $localidades = localidades::create([
                            'id_asenta' =>  $datos['id_asenta'],
                            'd_tipo_asenta' =>  $datos['d_tipo_asenta'],
                            'd_asenta' =>  $datos['d_asenta'],
                            'cod_postal' =>  $datos['cod_postal'],
                            'd_codigo' =>  $datos['d_codigo'],
                            'd_ciudad' =>  $datos['d_ciudad'],
                            'c_oficina' =>  $datos['c_oficina'],
                            'd_zona' =>  $datos['d_zona'],
                            'c_tipo_asenta' =>  $datos['c_tipo_asenta'],
                            'claveciudad' =>  $datos['claveciudad'],
                            'c_mnpio' => $municipios->c_mnpio,
                            'municipios_id' => $municipios->id,
                            
                        ]);


                    } else {
                        break;
                    }

                }

                //Si no hay ningun error termina la transaccion y se guardan los datos en la base de datos.
                DB::commit();
            } catch (\Exception $exception) {
                //en caso de algun erro cancela la transaccion y envia el error.
                DB::rollBack();

                return response()->json(['error' => $exception->getMessage()]);
            }
            //en caso de no detectar error manda un response de la localidad registrada.
            return response()->json('localidad registered', 201);
        }
    }



}