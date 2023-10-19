
<?php

/**
* Create by Bitts
* Objetivo: relembrar alguns conceitos de consulta de webservices usando PHP e jQuery
*/

//Buscando conteudo para popular o Select com as cidades de ORIGEM
$url_localidades = 'https://muviflex.com.br/api/venda-de-passagem/localidades-de-origem?isMuvibus=false&isPublicBody=false&userID=null'; 
$localidades_de_origem = file_get_contents($url_localidades);
$json_localidades_de_origem = json_decode( $localidades_de_origem, true);

$opt_origem = "<option value='0'> Selecione a Origem</option>";
foreach( $json_localidades_de_origem['data'] as $org ){
    if($org['id'] !== 0)
    $opt_origem .= "<option value='{$org['id']}' ibgeCode='{$org['ibgeCode']}'>{$org['city']}-{$org['state']} [{$org['busCompany']}]</option>";    
}


$valores = [];
foreach( $json_localidades_de_origem['data'] as $org ){
    
    if($org['id'] !== 0){
        $valores[$org['state']][] = array('id' => $org['id'], 'ibgeCode' => $org['ibgeCode'], 'city' => $org['city'], 'state' => $org['state'], 'busCompany' => $org['busCompany'] );
    }
}


$uf = $options = "";
foreach($valores as $state => $cidades){
    $options .= "<optgroup label='{$state}'>";
    foreach($cidades as $c){
        $options .= "<option value='{$c['id']}' ibgeCode='{$c['ibgeCode']}'>{$c['city']} [{$c['busCompany']}]</option>";
        
    }
    $options .= "</optgroup>";
    
}


if(isset($_REQUEST['originLocalityId']) && isset($_REQUEST['originIbgeCode']) && isset($_REQUEST['tripdate']) && isset($_REQUEST['destinationLocalityId']) && isset($_REQUEST['destinationIbgeCode']) && isset($_REQUEST['busCompany'])){
    
    $url = "https://muviflex.com.br/api/venda-de-passagem/rotas?tripdate={$_REQUEST['tripdate']}&originLocalityId={$_REQUEST['originLocalityId']}&originIbgeCode={$_REQUEST['originIbgeCode']}&destinationLocalityId={$_REQUEST['destinationLocalityId']}&destinationIbgeCode={$_REQUEST['destinationIbgeCode']}&busCompany={$_REQUEST['busCompany']}&portalOrigin=Portal+Muviflex";
    
    header("Content-Type: application/json");
    echo $venda_de_passagens = file_get_contents($url);
    
    /*
arrival : "2023-10-19T03:00:00"
busClass : "Direto"
classCode: "6"
conexao : null
departure : "2023-10-18T22:30:00"
destino : null
ehConexao : false
enterprise : "PLANALTO"
freeSeats : 44
group : "0112"
noBusChange : false
origem : null
price : "121.70"
promotion : false
promotionPercent : 0
raceDate : null
scheduleKey : "24970"
service : "3751"
showFreeSeats : false
totalSeats : 0
    */
    
}




else if(isset($_REQUEST['group']) && isset($_REQUEST['service']) && isset($_REQUEST['originIbgeCode']) && isset($_REQUEST['originLocalityId']) && isset($_REQUEST['destinationIbgeCode']) && isset($_REQUEST['destinationLocalityId']) && isset($_REQUEST['arrival']) && isset($_REQUEST['classCode']) && isset($_REQUEST['busCompany']) && isset($_REQUEST['scheduleKey']) ){
    
    $group = $_REQUEST['group']; //0112&
    $service = $_REQUEST['service']; //3735&
    $originIbgeCode = $_REQUEST['originIbgeCode']; //431490205000001&
    $originLocalityId = $_REQUEST['originLocalityId']; //15921&
    $destinationIbgeCode = $_REQUEST['destinationIbgeCode']; //431690705060001&
    $destinationLocalityId = $_REQUEST['destinationLocalityId']; //0&
    $tripDate = $_REQUEST['departure']; //2023-10-18T14:00:00&
    $classCode = $_REQUEST['classCode']; //4&
    $busCompany = $_REQUEST['busCompany']; //PLANALTO&
    $scheduleKey = $_REQUEST['scheduleKey']; //11550

    $url = "https://muviflex.com.br/api/venda-de-passagem/onibus?group={$group}&service={$service}&originIbgeCode={$originIbgeCode}&originLocalityId={$originLocalityId}&destinationIbgeCode={$destinationIbgeCode}&destinationLocalityId={$destinationLocalityId}&tripDate={$tripDate}&classCode={$classCode}&busCompany={$busCompany}&scheduleKey={$scheduleKey}";
    
    //echo $url;
    //$url = "https://muviflex.com.br/api/venda-de-passagem/onibus?group=0112&service=2520&originIbgeCode=431490205000001&originLocalityId=15921&destinationIbgeCode=431690705060001&destinationLocalityId=0&tripDate=2023-10-18T18:00:00&classCode=5&busCompany=PLANALTO&scheduleKey=33332";
    
    header("Content-Type: application/json");
    echo $localidades_de_destino = file_get_contents($url);
    
 /*  
group=0112&
price=204.55&
freeSeats=4&
showFreeSeats=false&
totalSeats=0&
service=3735&
busClass=Leito&
arrival=2023-10-18T20%3A30%3A00&
enterprise=PLANALTO&
departure=2023-10-18T16%3A00%3A00&
classCode=4&
scheduleKey=11550&
promotion=false&
promotionPercent=0&
raceDate=&
ehConexao=false&
conexao=&
origem=&
destino=&
noBusChange=false
*/
    
    
  
/*
{
    "group":"0112",
    "price":"121.70",
    "freeSeats":16,
    "showFreeSeats":false,
    "totalSeats":0,
    "service":"0808",
    "busClass":"Semi-Direto",
    "arrival":"2023-10-18T05:30:00",
    "enterprise":"PLANALTO",
    "departure":"2023-10-18T01:00:00",
    "classCode":"2",
    "scheduleKey":"##1#1801:0020231018#","promotion":false,"promotionPercent":0.0,"raceDate":null,"ehConexao":false,"conexao":null,"origem":null,"destino":null,"noBusChange":false},
*/  
  
   
}


//Isso aqui é feito para buscar as informações do Servidor do muviflex para as cidades de DESTINO
else if(isset($_REQUEST['originLocalityId']) && isset($_REQUEST['originIbgeCode'])){
    
    $url = "https://muviflex.com.br/api/venda-de-passagem/localidades-de-destino?isMuvibus=undefined&isPublicBody=false&userID=null&originLocalityId={$_REQUEST['originLocalityId']}&originIbgeCode={$_REQUEST['originIbgeCode']}";
    
    header("Content-Type: application/json");
    echo $localidades_de_destino = file_get_contents($url);

}else{



?>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <script src="https://momentjs.com/downloads/moment.js" ></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
        <script src="https://raw.githubusercontent.com/phstc/jquery-dateFormat/master/dist/jquery-dateformat.js"></script>
    
        <style>
            .destinos{ display: none; }
            
            .resposta ul {
                width: 100%;
            }
            
            .resposta ul > li > div {
                float: left;
                margin-left: 0.5em;
                border: 1px solid #ccc;
                padding: 0.1em;
                border-radius: 0.2em;
            }
            
            .resposta ul > li {
                border: 1px solid red;
                border-radius: 0.2em;
                float: left;
                padding: 0.2em;
                display: grid;
                margin: 0.5em;
            }
            .poltronas div.item {
                float: left;
                width: 35px;
                height: 35px;
                border: 1px solid red;
            }

            div.poltronas {
                width: 180px;
                text-align: center;
            }

            .poltronas div.item {
                float: left;
                width: 35px;
                height: 35px;
                border: 1px solid red;
            }

            div.poltronas {
                width: 180px;
                text-align: center;
            }

            div.pol_number {
                text-align: left;
                padding-top: 0.1em;
                padding-left: 0.5em;
                font-size: 8pt;
                color: gray;
            }

            div.pol_vaga {
            }

            div.pol_available {
                font-size: 8pt;
            }

            table.tb_poltronas {
                font-size: 8pt;
                border: 1px solid black;
            }

            table.tb_poltronas, table.tb_poltronas th, table.tb_poltronas td {
                border: 1px solid;
                text-align: center;
            }
        </style>
    
        
        <script type="text/javascript">
            function addZero(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
            function getActualDate() {
                var d = new Date();
                var day = addZero(d.getDate());
                var month = addZero(d.getMonth()+1);
                var year = addZero(d.getFullYear());
                return day + "/" + month + "/" + year;
            }
            
            function montaTable(busSeats){
                
                var itens = new Array();
                let dv = $('<div />').addClass('poltronas');
                $.each(busSeats, function(i, obj){
                    
                    itens.push(obj.number);
                    
                    dv.append(
                        $('<div />')
                            .addClass('item itm_'+ obj.x +'_'+ obj.y)
                            .attr({'x': obj.x, 'y': obj.y})
                            .append(
                                $('<div />').addClass('pol_number').text(obj.number),
                                $('<div />').addClass('pol_vaga').text(obj.type),
                                //$('<div />').addClass('pol_available').text(obj.available)
                            )
                    );
                    
                });
                
                
                //console.log(itens);
                
                var colunas = 3;
                var linhas = 20;
                var cnt = 1;
                var tb = $('<table />').addClass('tb_poltronas');
                for(i=0; i <= linhas; i++ ){
                    var tr = $('<tr />');
                    for( j = 0; j <= colunas; j++){
                        
                        var vd = false;
                        $.each(itens, function(i, item){
                           if(item == cnt){
                               vd = true;
                           }
                        });
                        
                        let td = $('<td />')
                                    .addClass('ln_'+ i +'_'+ j)
                                    .append( 
                                        $('<div />').addClass('tb_poltronas_contagem').append( cnt ),
                                        vd?'Vendido':''
                                    );
                                    
                        tr.append(td);
                        cnt++;
                    }
                    tb.append(tr);
                }
                
                dv.append(tb);
                
                return dv;
                
            }
        
	    $(document).ready(function() {
			    
	    	$("input[name*='data']").mask("99/99/9999", {placeholder: 'MM/DD/YYYY' }).val(getActualDate());
                
                $('.localidades').on("change", function() {
                
                    var id = $(this).find('option:selected').val();
                    var ibgeCode = $(this).find('option:selected').attr('ibgeCode');
                    
                    $.ajax({
                        type: "get",
                        data: {
                            'originLocalityId': id, 
                            'originIbgeCode' : ibgeCode
                        },
                        dataType: 'json',
                        success: function (result) {
                            $("select[name='destinos']").append('<option value="0"> Selecione o Destino </option>');
                            if(result && result.data){
                                $.each(result.data, function (key, value) {
                                    $("select[name='destinos']").append(`
                                        <option value="${value.id}" ibgeCode="${value.ibgeCode}" busCompany="${value.busCompany}">
                                            ${value.city} - ${value.state} [${value.busCompany}]
                                        </option>
                                    `);
                                });
                            }
                        },
                        error : function(err){
                            console.log(err);
                        },
                        complete : function(){
                            $('.destinos').show();
                        }
                    });
                });
                
                
                $("form").submit(function(e){
                    
                    e.preventDefault();
                    
                    var id = $('.localidades').find('option:selected').val();
                    var ibgeCode = $('.localidades').find('option:selected').attr('ibgeCode');
                    
                    var tripdate = moment( $("input[name='data_ida']").val() , "DD/MM/YYYY").format('YYYY-MM-DD');
                    //var tripdate = $.datepicker.formatDate( "dd-MM-yyyy", $("input[name='data_ida']").val() );


                    var destinationLocalityId = $('.destinos').find('option:selected').val();
                    var destinationIbgeCode = $('.destinos').find('option:selected').attr('ibgeCode');
                    var busCompany = $('.destinos').find('option:selected').attr('busCompany');
                    
                    $.ajax({
                        type: "get",
                        data: {
                            'originLocalityId': id, 
                            'originIbgeCode' : ibgeCode,                            
                            'tripdate' : tripdate,
                            'destinationLocalityId' : destinationLocalityId,
                            'destinationIbgeCode' : destinationIbgeCode,
                            'busCompany' : busCompany
                        },
                        dataType: 'json',
                        success: function (result) {

                            if(result && result.data){
                                $.each(result.data.ticketRoutes, function (key, value) {
                                    let arrival = moment( value.arrival ).format('HH:mm:ss DD/MM/YYYY');
                                    let departure = moment( value.departure ).format('HH:mm:ss DD/MM/YYYY');
                                    
                                    value.originIbgeCode = ibgeCode;
                                    value.originLocalityId = id;
                                    value.destinationIbgeCode = destinationIbgeCode;
                                    value.destinationLocalityId = destinationLocalityId;
                                    value.tripDate = tripdate;
                                    value.busCompany = busCompany;
                                    
                                    $(".resposta ul").append(
                                        $('<li />').append(
                                            $('<div />').text(value.busClass),
                                            $('<div />').text('Chegada:'+ arrival),
                                            $('<div />').text('Saida:'+ departure),
                                            $('<div />').text('Empresa:'+ value.enterprise),
                                            $('<div />').text('Lugares Livres:'+ value.freeSeats),
                                            $('<div />').text('Preço: R$ '+ value.price),
                                            $('<button />').text('Detalhes').click(function(){
                                                
                                                let item = $(this);
                                                $.ajax({
                                                    type: "get",
                                                    data:  value,
                                                    dataType: 'json',
                                                    success: function (resp) {
                                                        
                                                        item.after( montaTable(resp.data.busSeats) );
                                                        
                                                        
                                                
                                                    }
                                                });                                                
                                                
                                            })
                                        )
                                    );
                                });
                            }
                            
                            

                            
                            /*
                            "ticketRoutes":[
                            
                                {"group":"0112","price":"121.70","freeSeats":16,"showFreeSeats":false,"totalSeats":0,"service":"0808","busClass":"Semi-Direto","arrival":"2023-10-18T05:30:00","enterprise":"PLANALTO","departure":"2023-10-18T01:00:00","classCode":"2","scheduleKey":"##1#1801:0020231018#","promotion":false,"promotionPercent":0.0,"raceDate":null,"ehConexao":false,"conexao":null,"origem":null,"destino":null,"noBusChange":false},
                                
                                {"group":"0112","price":"204.55","freeSeats":0,"showFreeSeats":false,"totalSeats":0,"service":"0808","busClass":"Leito","arrival":"2023-10-18T05:30:00","enterprise":"PLANALTO","departure":"2023-10-18T01:00:00","classCode":"4","scheduleKey":"##111901:0020231018#","promotion":false,"promotionPercent":0.0,"raceDate":null,"ehConexao":false,"conexao":null,"origem":null,"destino":null,"noBusChange":false},
                                
                                {"group":"0112","price":"157.40","freeSeats":10,"showFreeSeats":false,"totalSeats":0,"service":"0808","busClass":"Executivo","arrival":"2023-10-18T05:30:00","enterprise":"PLANALTO","departure":"2023-10-18T01:00:00","classCode":"5","scheduleKey":"##1#9801:0020231018#","promotion":false,"promotionPercent":0.0,"raceDate":null,"ehConexao":false,"conexao":null,"origem":null,"destino":null,"noBusChange":false},
                                
                                {"group":"0112","price":"125.20","freeSeats":31,"showFreeSeats":false,"totalSeats":0,"service":"1126","busClass":"Semi-Direto","arrival":"2023-10-18T06:20:00","enterprise":"PLANALTO","departure":"2023-10-18T01:10:00","classCode":"2","scheduleKey":"##1#2601:1020231018#","promotion":false,"promotionPercent":0.0,"raceDate":null,"ehConexao":false,"conexao":null,"origem":null,"destino":null,"noBusChange":false},
                            */
                            
                            
                        },
                        error : function(err){
                            console.log(err);
                        },
                        complete : function(){
                            
                        }
                    });
                });
                
	     });
        </script>
    </head>
    
    <body>
    
        <h1> Passagens de Onibus</h1>
    
        <ul class="favoritos">
            <li><a href="?id=15921">Porto Alegre - RS</a></li>
            <li><a href="?id=15956">Santa Maria - RS</a></li>
            <li><a href="?id=15992">Pelotas - RS</a></li>
        </ul>
    
        <form name="search_passagens" method="POST">
            <p class="localidades">
                Localidades 
                <select name="localidades">
                    <? /*echo $opt_origem;*/ ?>
                    <? echo $options; ?>
                </select>
            </p>
            
            <div class="destinos">
                <p>
                    Destino 
                    <select name="destinos">
                            
                    </select>
                </p>
                <p>
                    <input type="text" name="data_ida"  >Data de Ida
                </p>
                <p>
                    <input type="text" name="data_volta"  >Data de Volta
                </p>
            </div>
            <input type="submit"></input>
            
        </form>
    
    
        <div class="resposta">
            <ul></ul>
        </div>
    </body>

</html>

<?php

}

?>
