<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action
{

	public function index()
	{

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			$this->render('index');
        } else {
			header('Location: /timeline');
		}
		
	}

	public function inscreverse()
	{
		$this->view->erroCadastro = false;
		$this->view->usuario = [
			'nome' => '',
			'email' => '',
			'senha' => ''
		];
		$this->render('inscreverse');
	}

	public function registrar()
	{

		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) === 0) {

			$usuario->salvar();
			$this->render('cadastro');
		} else {
			$this->view->usuario = [
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			];
			$this->view->erroCadastro = true;
			$this->render('inscreverse');
		}
	}
}
