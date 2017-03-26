<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Index extends Controller
{
    /**
     * Abre la vista
     *
     * @return void
     */
    public function index()
    {
        config(['customs.isMatrixInitialized' => false]);
        return view('index');
    }

    /**
     * Actualiza la matriz con determinado valor
     *
     * @param Request $request peticion via post
     *
     * @return void
     */
    public function update(Request $request)
    {
        //miramos si la matriz se ha inicializado
        if (config('app.isMatrixInitialized')) {
            //miramos que hayan casos de prueba activos
            if (config('app.testCases') !==0) {
                //revisamos que hayan operaciones disponibles
                if (config('app.operations') !== 0) {
                    $nums = $request->all();
                    $matrix = config('app.matrix');
                    //actualizamos la matriz
                    $matrix[$nums[0]][$nums[1]][$nums[2]] = $nums[3];
                    //reducimos las operaciones
                    config(['app.operations' => config('app.operations')--]);
                    //establecemos la matriz en el objeto global
                    config(['app.matrix' => $matrix]);
                } else {
                    //reducimos los casos de pruebas
                    config(['app.testCases' => config('app.testCases')--]);
                }
            } else {
                //devolvemos la validacion
                return json_encode('Se han terminado los casos de prueba');
            }
        }
    }

    /**
     * Sumamos la matriz incluyendo determinados valores en X, Y y Z
     *
     * @param Request $request peticion via post
     *
     * @return void
     */
    public function query()
    {
        $sumValues = $request->all();
        if (config('app.isMatrixInitialized')) {
            if (config('app.testCases') !==0) {
                if (config('app.operations') !== 0) {
                    $nums = $request->all();
                    $matrix = config('app.matrix');
                    $sum = $matrix[$sumValues[0]][$sumValues[1]][$sumValues[2]] + $matrix[$sumValues[3]][$sumValues[4]][$sumValues[5]];
                    return json_decode(['sum' => $sum]);
                } else {
                    config(['app.testCases' => config('app.testCases')--]);
                }
            } else {
                return json_encode('Se han terminado los casos de prueba');
            }
        }
    }

    /**
     * Establece la cantidad de casos que se validaran
     *
     * @param Request $request peticion via post
     *
     * @return void
     */
    public function setTestCases(Request $request)
    {
        $post = $request->all();
        //recibimos y establecemos la cantidad de estados de prueba
        config([
            'testCases' => (int) $post['testCases']
        ]);
    }

    /**
     * inicializamos la matriz
     *
     * @param Request $request peticion via post
     *
     * @return void
     */
    public function initializeMatrix(Request $request)
    {
        $init = $request->all();
        //establecemos las variables globales e inicalizamos la matriz
        config([
            'app.matrix' => array_fill(1, $init['size'], array_fill(1, $init['size'], array_fill(1, $init['size'], 0))),
            'app.operations' => $init['operations'],
            'app.isMatrixInitialized' => true
        ]);
    }
}
