<?php

namespace Pessoa\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Pessoa implements ArraySerializableInterface
{
    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $situacao;

    public function exchangeArray(array $array){
        $this->id = !empty($array['id']) ? $array['id'] : null ;
        $this->nome = !empty($array['nome']) ? $array['nome'] : null ;
        $this->sobrenome = !empty($array['sobrenome']) ? $array['sobrenome'] : null ;
        $this->email = !empty($array['email']) ? $array['email'] : null ;
        $this->situacao = !empty($array['situacao']) ? $array['situacao'] : null ;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'email' => $this->email,
            'situacao' => $this->situacao
        ];
    }
}