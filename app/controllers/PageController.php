<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class PageController extends Controller
{
    public function contact(): void
    {
        $this->view('page.contact', ['title' => 'Contact Us']);
    }

    public function dmca(): void
    {
        $this->view('page.dmca', ['title' => 'DMCA']);
    }

    public function privacy(): void
    {
        $this->view('page.privacy', ['title' => 'Privacy Policy']);
    }

    public function terms(): void
    {
        $this->view('page.terms', ['title' => 'Terms of Service']);
    }
}
