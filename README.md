# Desafio 123 Milhas

Conforme foi proposto na documentação, o desafio consistia em consumir uma API e realizar os devidos tratamento dos seus dados. Neste caso específico, foi consumida uma API que nos retorna alguns voos 
e o objetivo é agrupar este voos seguindos alguns critérios.


## Escolha técnica

Como o objetivo era consumir e tratar os dados de uma API, optei pelo Lumen por conter tudo que era necessário para as trativas. Caso escolhido o laravel, não seria utilizado muitos dos recursos.

Documentação do Lumen [Lumen website](https://lumen.laravel.com/docs).

## Estrutura do Projeto

Buscando um melhor aproveitamento de código e uma arquitetura mais limpa o projeto foi estruturado da seguinte forma:
-   app/Factory/GuzzleFactory : Arquivo responsável por abstrair as requisições na API. Como neste desafio o proposto era apenas um consumo através do método GET, temos apenas um método : createGetRequisition, responsável por fazer requisições GET. 

- app/Services/FlightService: neste  serviço preparamos os parâmetros que desejamos consumir como por exemplo: URL, e paramêtros caso tenha

- app/Services/BusinessFlightService:  neste arquivo propriamente  dito, temos as regras para agrupamento dos voos. Este arquivo está responsável por aplicar as regras necessárias nos nossos dados.

- app/Console/Commands/SwaggerScan : arquivo responsável para atualizar nosso swagger

- app/Http/Controllers/FlightController : nese projeto o controller foi usado para  que pudessemos fazer as devidas chamadas dos serviços.

## Instalação do projeto

Para instalar e executar o projeto basta que adotemos o seguinte passo-a-passo:

- Clonar o projeto: git clone https://github.com/bhfagundes/123_milhas.git
- Instalar as dependências do projeto : entrar na pasta criada através do item acima e excutar o comando : composer install
- Caso tenha sido criado o arquivo .env, copiar o código do arquivo .env.example e sobrescrever o conteúdo gerado. Caso não  tenha, basta renomear o arquivo  .env.example para .env . Neste arquivo temos algumas configurações importantes do projeto, uma  delas é algo  que visa facilitar a manutenção na API. Temos uma variável responsável por especificar qual o endereço estamos consumindo, de nome URL_API_MILHAS
- Executar o comando para atualizar a documentação do swagger : php  artisan swg:scan
- Feito os passos acima podemos startar nossa aplicação. Como estamos executando local, podemos executá-la na porta 8000 usando o comando no terminal : php -S localhost:8000 -t public


## Endpoints

Para o projeto, temos um endpoint que retorna os voos agrupados. Sendo ele:

- http://localhost:8000/ : método get, sem body

Para facilitar  também a visualização e testes se encontra disponível:

- collection do postman : https://www.getpostman.com/collections/d1d28183ba382d9ad6ec
- Swagger do projeto : http://localhost:8000/swagger-ui.html


## Agradecimentos

- Agradeço toda a equipe 123 Milhas pela oportunidade de realizar um processo. Vejo como uma grande oportunidade para crescimento profissional e pessoal. 
