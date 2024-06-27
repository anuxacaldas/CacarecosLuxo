
<?php
if(session_status() == PHP_SESSION_NONE) {
  session_start();
}
  require_once "conexao.php"; 
  require_once "topo.php";

?>

<link rel="stylesheet" href="css/style.css">

<!--CAROUSEL--> 
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="imagens/banners/2.svg" alt="Primeiro Slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imagens/banners/1.svg" alt="Segundo Slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imagens/banners/3.svg" alt="Terceiro Slide">
    </div>
  </div>

  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Próximo</span>
  </a>
</div>

<!--FIM L--> 

<?php
echo '<div class="search-form buscar" style="background-color: #637D72;">';
echo '    <h5>O que fazemos por você e pelo ambiente?</h5>';
echo '</div>';
?>

<div class="linha w3-col l3 m6 w3-container w3-caixa w3-padding-16" style="text-align: justify; background-color: #CCCCCC; color: #343A40;" height=300px>
  <img src="imagens/img/3.png" width="215px" style="display: block; margin: 0 auto;"> 
  <h4 style="text-align: center;">Soluções de móveis sustentáveis
  </h4>
  Fornecer serviços de móveis ecológicos para comunidades de baixa renda, promovendo sustentabilidade e acessibilidade.<br><br>
</div>

<div class="linha w3-col l3 m6 w3-container w3-padding-16" style="text-align: justify; background-color: #CCCCCC; color: #343A40;"  height=300px>
  <img src="imagens/img/6.png" width="215px" style="display: block; margin: 0 auto;">
  <h4 style="text-align: center;">Restauração de móveis ecológicos</h4>
  A nossa equipe é especializada em restaurar móveis e estofados de forma sustentável, 
  dando-lhes uma nova vida e reduzindo o desperdício.
</div>
    
<div class="linha w3-col l3 m6 w3-container w3-padding-16" style="text-align: justify; background-color: #CCCCCC; color: #343A40;" height=300px>
  <img src="imagens/photo2.jpeg" width="215px" style="display: block; margin: 0 auto;">      
  <h4 style="text-align: center;">Opções de móveis acessíveis</h4>
  A nossa empresa oferece venda de móveis e estofados a baixo custo, tornando peças de qualidade acessíveis a comunidades de baixa renda e ao mesmo tempo promovendo a sustentabilidade.<br><br>
</div>

<div class="linha w3-col l3 m6 w3-container w3-caixa w3-padding-16" style="text-align: justify; background-color: #CCCCCC; color: #343A40;" height=300px>
  <img src="imagens/img/10.png" width="215px" style="display: block; margin: 0 auto;"> 
  <h4 style="text-align: center;">Impacto na comunidade</h4>
  Ao apoiar a Cacarecos de Luxo, você contribui para uma economia circular, ajudando o meio ambiente e fornecendo 
  móveis acessíveis a quem precisa.
</div>
      

<div class=row><div class="col-md-4 mt-4 pt-2">
  <div class="card work-process border-0 rounded shadow">
    <div class=card-body>
      <img src=imagens/icons/sofa.png class="avatar avatar-small lazyload" alt><br>
      <h4 class=title>Envie os detalhes</h4>
      <p class="text-muted para">Adicione uma  foto e alguns detalhes para que possamos analisar.</p>
      
      </div>
    </div>
  </div>
  <div class="col-md-4 mt-4 pt-2">
    <div class="card work-process border-0 rounded shadow">
      <div class=card-body>
      <img src=imagens/icons/entrega.png  class="avatar avatar-small lazyload" alt><br>
        <h4 class=title>Retiramos</h4>
        <p class="text-muted para">Após a análise da coleta, agendamos a retirada.</p>
    </div>
  </div>
</div>

<div class="col-md-4 mt-4 pt-2">
  <div class="card work-process border-0 rounded shadow">
    <div class=card-body>
    <img src=imagens/icons/restaura.png  class="avatar avatar-small lazyload" alt><br>
      <h4 class=title>Restauramos</h4>
      <p class="text-muted para">As peças são restauradas e disponibilizadas para venda.</p>

      </div>
    </div>
  </div>
</div></div></section><br>




<div class="" style="text-align: justify title; background-color: #A0B1AA;"  height=30px>
<div class="row justify-content-center">
  <h3 class=" mb-4">Como funciona?</h3>

</div>
</div><br>


<br><br><br>

<section class="section overflow-hidden">
  <div class="container mt-100 mt-60">
    <div class="row align-items-center">
      <div class="col-lg-5 col-md-6 col-12 order-1 order-md-2"><picture>
        <img src=imagens/img/12.png class="img-fluid mx-auto d-block card work-container overflow-hidden rounded border-0 shadow-lg lazyload" alt></picture>
      </div>
      <div class="col-lg-7 col-md-6 col-12 order-2 order-md-1 mt-4 pt-2 mt-sm-0 pt-sm-0">
        <div class="section-title mr-lg-4">
          <p class="text-primary h2 mb-3"><i class="uim uim-layer-group"></i></p>
          <h4 class="title mb-3">Você envia os detalhes do item<br>
          <span class=text-primary>que será recolhido</span></h4>
          <p class="text-muted text-justify">É muito fácil solicitar o que você está pronto para desfazer. 
            Nossa equipe analisará cada produto e fará uma pesquisa detalhada. 
            Nosso foco é manter móveis duráveis ​​e com qualidade fora do lixo e descartados inadequadamente, 
            por isso somos seletivos quanto as coletas.
          </p>
          <ul class="list-unstyled feature-list text-muted">
            <li><i  class="fea icon-sm text-success mr-2">&check;</a></i>Faça seu cadastro</li>
            <li><i data-feather=check-circle class="fea icon-sm text-success mr-2">&check;</a></i>Preencha o formulário de solicitação</li>
            <li><i data-feather=check-circle class="fea icon-sm text-success mr-2">&check;</a></i>Anexe uma foto com qualidade</li>
            <li><i data-feather=check-circle class="fea icon-sm text-success mr-2">&check;</a></i>Envie informações relevantes</li>
          </ul>
        </div>
        <div class=mt-4><a class="typeform-share button btn btn-primary" href=cadcliente.php>Faça seu cadastro<i class="mdi mdi-chevron-right"></i></a>

    </div>
  </div>
</div><br><br><br>
</section>


<section class=section><div class="container mt-100 mt-60">
  <div class="row align-items-center">
    <div class="col-lg-5 col-md-6 col-12">
      <div class=social-feature-left><picture>
        <img src=imagens/img/11.png class="img-fluid mx-auto d-block card work-container overflow-hidden rounded border-0 shadow-lg lazyload" alt>
      </picture>
    </div>
  </div>
  <div class="col-lg-7 col-md-6 col-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
    <div class="section-title ml-lg-4">
      <p class="text-primary h2 mb-3">
        <i class="uim uim-airplay"></i>
      </p>
      <br><br><h4 class="title mb-3">Agora deixa com a gente,<br>
      <span class=text-primary>nós cuidamos</span> do resto</h4>
      <p class="text-muted text-justify">Com a análise concluída, nossa equipe entrará em contato para 
        agendar a retirada dos seus produtos o mais rápido possível. 
        O valor da retirada é descontado após as vendas e pode variar de acordo com seu endereço
        (o valor será informado com o agendamento da retirada), você também pode trazer os 
        produtos gratuitamente até nosso armazém.
      </p>
      
      <a class="typeform-share button btn btn-primary" href="addcoleta.php">Solicite uma coleta<i class="mdi mdi-chevron-right"></i></a>
      <br><br><br>
      </div><br>

    </div>
  </div>
</section>
<br>


<section class="section overflow-hidden">
  <div class="container mt-100 mt-60">
    <div class="row align-items-center">
      <div class="col-lg-5 col-md-6 col-12 order-1 order-md-2"><picture>
          <img src=imagens/img/13.png class="img-fluid mx-auto d-block card work-container overflow-hidden rounded border-0 shadow-lg lazyload" alt></picture>
        </div>
        <div class="col-lg-7 col-md-6 col-12 order-2 order-md-1 mt-4 pt-2 mt-sm-0 pt-sm-0">
          <div class="section-title mr-lg-4">
            <p class="text-primary h2 mb-3"><i class="uim uim-cube"></i></p>
            <h4 class="title mb-3">Móvel recolhido? Mãos <span class=text-primary>a obra!</span></h4>
            <p class="text-muted text-justify">Agradecemos a sua contribuição com a nossa empresa e com o ambiente. 
              Fazemos todo o trabalho necessário para obter o máximo aproveitamento de seus móveis, 
              estabelecendo preços que cabe no bolso da família de baixa renda. 
            Quando um item é recolhido, ele não passa apenas por um processo de transformação. Contribuimos com um ambiente
            mais saudável, seguro e sustentável. Afinal, evitamos a proliferação de escorpiões, ratos, baratas e outras doenças, 
            causadas pelo lixo descartado incorretamente. Desta forma, estaremos fazendo o bem para todos!</p>
            <div class=mt-4>
              <a class="typeform-share button btn btn-primary" href="galeria.php">Conheça nossos produtos<i class="mdi mdi-chevron-right"></i></a>
              <br><br><br><br>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>
    <br><br><br>

</html>


<?php
require_once "rodape.php";

?>

<a id="linktopo" href="#">&#9650; </a>





