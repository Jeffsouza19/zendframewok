<?php

namespace Pessoa\Controller;

use Pessoa\Form\PessoaForm;
use Pessoa\Model\Pessoa;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PessoaController extends AbstractActionController
{

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel(['pessoas' => $this->table->fetchAll()]);
    }

    /**
     * @return Response|ViewModel
     */
    public function adicionarAction()
    {
        $form = new PessoaForm();
        $form->get('submit')->setValue('Adicionar');

        $request = $this->getRequest();
        if(!$request->isPost()){
            return new ViewModel(['form' => $form]);
        }
        $pessoa = new Pessoa();
        $form->setData($request->getPost()); 

        if(!$form->isValid()){
            return new ViewModel(['form' => $form]);
        }

        $pessoa->exchangeArray($form->getData());
        $this->table->salvarPessoa($pessoa);

        return $this->redirect()->toRoute('pessoa');
    }

    public function editarAction(): ViewModel
    {
        return new ViewModel();
    }

    public function removerAction(): ViewModel
    {
        return new ViewModel();
    }

    public function confirmacaoAction(): ViewModel
    {
        return new ViewModel();
    }
}