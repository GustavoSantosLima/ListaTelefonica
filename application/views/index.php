<!DOCTYPE html>
<html lang="pt-br" ng-app="Sistema">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="">
        <title>Lista Telefonica</title>
        <!-- Bootstrap core CSS -->
        <link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <script src="<?= base_url('assets/js/angular.min.js'); ?>"></script>
        <script>
            angular.module('Sistema', []);
            angular.module('Sistema').controller('sistemaCtrl', function($scope, $http){
                $scope.titulo = "Lista Telefônica";
                $scope.contatos = [];
                $scope.operadoras = [];
                var CarregarContatos = function(){
                    $http.get(
                        "http://localhost/Projetos/ListaTelefonica/sistema/contatos"
                    ).success(function(data, status){
                        $scope.contatos = data;
                    });
                };
                var CarregarOperadoras = function(){
                    $http.get(
                        "http://localhost/Projetos/ListaTelefonica/sistema/operadoras"
                    ).success(function(data, status){
                        $scope.operadoras = data;
                    });
                };
                $scope.adicionaContato = function(contato){
                    $http.post(
                        "http://localhost/Projetos/ListaTelefonica/sistema/contatos",
                        contato
                    ).success(function(data){
                        delete $scope.contato;
                        $scope.contatoForm.$setPristine();
                    });

                };
                $scope.apagarContato = function(contatos){
                    $scope.contatos = contatos.filter(function(contato){
                        if(!contato.selecionado) return contato;
                    });
                };
                $scope.isSelecionado = function(contatos){
                    return contatos.some(function(contato){
                        return contato.selecionado;
                    })
                };

                CarregarContatos();
                CarregarOperadoras();
            });
        </script>
    </head>
    <body ng-controller="sistemaCtrl">
        <div class="container">
            <div class="jumbotron col-sm-6 col-sm-offset-3">
                <h3 class="text-center titulo">{{titulo}}</h3>
                <div class="row"  ng-show="contatos.length > 0">
                    <input class="form-control" type="text" ng-model="busca" placeholder="Pesquisar..." >
                    <table class="table">
                        <tr class="table-head">
                            <th></th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Operadora</th>
                        </tr>
                        <tr ng-repeat="contato in contatos | filter: busca | orderBy: 'nome'" ng-class="{'selecionado': contato.selecionado}">
                            <td><input type="checkbox" ng-model="contato.selecionado" ></td>
                            <td>{{contato.nome}}</td>
                            <td>{{contato.telefone}}</td>
                            <td>{{contato.operadora.name}}</td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <form name="contatoForm">
                        <input class="form-control" type="text" ng-model="contato.nome" name="nome" placeholder="Digite o nome..." ng-required="true" ng-minlength="3">
                        <input class="form-control" type="text" ng-model="contato.telefone" name="telefone" placeholder="Digite o telefone..." ng-required="true" ng-pattern="/^\d{4,5}-\d{4}$/">
                        <!--<select class="form-control" ng-model="contato.operadora" ng-options="operadora.nome for operadora in operadoras">-->
                        <!--<select class="form-control" ng-model="contato.operadora" ng-options="operadora.codigo as operadora.nome for operadora in operadoras">-->
                        <select class="form-control" ng-model="contato.operadora" ng-options="operadora.id as operadora.name group by operadora.categoria for operadora in operadoras | orderBy: 'nome'">
                            <option value="">Selecione a operadora</option>
                        </select>
                    </form>
                    <div>
                        <p class="alert alert-danger" ng-if="contatoForm.nome.$error.required && contatoForm.nome.$dirty">Preencha o campo nome!</p>
                        <p class="alert alert-danger" ng-if="contatoForm.nome.$error.minlength">O campo nomedeve ter no minimo 3 caracteres!</p>
                        <p class="alert alert-danger" ng-if="contatoForm.telefone.$error.required && contatoForm.telefone.$dirty">Preencha o campo Telefone!</p>
                        <p class="alert alert-danger" ng-if="contatoForm.telefone.$error.pattern">O campo Telefone deve ter o formato 99999-9999!</p>
                    </div>
                    <button class="btn btn-primary btn-block" ng-click="adicionaContato(contato)">Salvar</button>
                    <button class="btn btn-danger btn-block" ng-click="apagarContato(contatos)" ng-show="isSelecionado(contatos)">Apagar</button>
                </div>
            </div>
        </div>
    </body>
</html>