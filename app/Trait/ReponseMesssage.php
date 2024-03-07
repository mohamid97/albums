<?php

namespace App\Trait;

trait ReponseMesssage{

    // can hamdle more in future
    public function response($type , $message) {
        return redirect()->back()->with($type, $message);
    }
}