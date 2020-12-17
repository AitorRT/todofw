<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class DashboardController extends Controller{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $db = $this->getDB();
        $dataview = ['title' => 'Todo'];
        $this->render($dataview);
    }
    public function insertTask()
    {
        $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $user = $this->session->get('uname');
        $data = ['description' => $desc, 'user' => $user['id'], 'due_date' => $date];
        $result = $this->getDB()->insert('tasks', $data);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $result], 'dashboard');
    }
    public function selectTask()
    {
        $user = $this->session->get('uname');
        $condition = ['user', $user['id']];
        $data = $this->getDB()->selectWhere('tasks', ['id', 'description', 'due_date'], $condition);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $data], 'dashboard');
    }
    public function deleteTask()
    {
        $idT = filter_input(INPUT_POST, 'idT', FILTER_SANITIZE_STRING);
        $user = $this->session->get('uname');
        $data = $this->getDB()->remove('tasks', $idT);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $data], 'dashboard');
    }
    public function modifyTask()
    {
        $ndesc = filter_input(INPUT_POST, 'changedDesc', FILTER_SANITIZE_STRING);
        $ndate = filter_input(INPUT_POST, 'changedDate', FILTER_SANITIZE_STRING);
        $nidTask = filter_input(INPUT_POST, 'changedIdT', FILTER_SANITIZE_STRING);
        $user = $this->session->get('uname');
        $data = ['description' => $ndesc, 'due_date' => $ndate];
        $conditions = ['id', $nidTask];
        $result = $this->getDB()->update('tasks', $data, $conditions);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $result], 'dashboard');
    }
}
