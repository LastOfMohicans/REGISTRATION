<?php 

namespace App\View;

use App\Traits\Magic;

class View
{
    use Magic;

    public function render($template)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }

        include __DIR__ . '/templates/' . $template . '.php';
    }

    public function display($template)
    {
        echo $this->render($template);
    }
}