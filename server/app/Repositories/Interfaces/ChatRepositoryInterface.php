<?php
    namespace App\Repositories\Interfaces;


    Interface ChatRepositoryInterface{

        public function list($user_id, $project_id);
        public function send($data);
    }
