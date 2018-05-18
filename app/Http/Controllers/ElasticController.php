<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElasticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'index' => 'rick-index',
            'type' => 'article',
        ];

        $res = \Elasticsearch::search($data);

        $response = collect(array_get($res,'hits.hits',[]))->pluck('_source')->map(function($item){
            return [
                'id' => $item['id'],
                'content' => $item['content']
            ];
        });

        dd($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $params = [
            'query' => [
                'must' => [
                    'match' => [
                        'id' => $id
                    ],
                ]
            ]
        ];

        $data = [
            'index' => 'rick-index',
            'type' => 'article',
            'body' => $params
        ];

        $res = \Elasticsearch::search($data);

        $response = collect(array_get($res,'hits.hits',[]))->pluck('_source')->map(function($item){
            return [
                'id' => $item['id'],
                'content' => $item['content']
            ];
        });

        dd($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
