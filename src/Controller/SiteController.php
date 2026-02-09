<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\View\View;


    final class SiteController
    {
        private View $view;

        public function __construct(View $view)
        {
            $this->view = $view;
        }

        public function home(): void
        {
            $this->view->renderPage('home', [
                'title' => "Home"
            ]);
        }

        public function show(string $id): void
        {
            $this->view->renderPage('show', [
                'title' => 'show',
                'id' => $id
            ]);
        }
    }