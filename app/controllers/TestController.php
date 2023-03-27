<?php

class TestController extends Controller
{
    public function home()
    {
        return view('home', [
            'bb' => 'hih'
        ]);
    }

    public function test()
    {
        return view('test', [
            'aa' => '11hih'
        ]);
    }
}
