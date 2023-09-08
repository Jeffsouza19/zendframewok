<?php

namespace Pessoa\Controller;

use Exception;
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


    /**
     * @return array|Response
     */
    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id){
            return $this->redirect()->toRoute('pessoa', ['action' => 'adicionar']);
        }

        try {
            $pessoa = $this->table->getPessoa($id);
        }catch (Exception $e){
            return $this->redirect()->toRoute('pessoa', ['action' => 'index']);
        }

        $form = new PessoaForm();
        $form->bind($pessoa);
        $form->get('submit')->setAttribute('value', 'Salvar');
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if(!$request->isPost()){
            return $viewData;
        }

        $form->setData($request->getPost());

        if(!$form->isValid()){
            return $viewData;
        }

        $this->table->salvarPessoa($pessoa);

        return $this->redirect()->toRoute('pessoa');

    }

    /**
     * @return array|Response
     */
    public function removerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id){
            return $this->redirect()->toRoute('pessoa');
        }
        $request = $this->getRequest();
        if ($request->isPost()){

            $del = $request->getPost('del','nao');

            if ($del == 'Sim'){
               $id = (int) $request->getPost('id');
               $this->table->deletarPessoa($id);
            }

            return $this->redirect()->toRoute('pessoa');
        }

        return ['id' => $id, 'pessoa' => $this->table->getPessoa($id)];
    }
}