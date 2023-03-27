<?php

class TestController extends Controller
{
    public function home($id = null, $value = null)
    {
        return Response::success('Success', [
            'id' => $id,
            'value' => $value
        ]);
    }
}
