<style type="text/css">

div.list-button-bar-top {
  padding-top: 5px;
  padding-bottom: 10px;
}

div.list-button-bar-top .compact li {
    display: inline;
}

div.list-button-bar-top ul.compact {
    padding:0;
}

ul.compact {
  padding:0;
  list-style-type:none;
}

ul.compact li {
  display:inline;
}

div.list-button-bar-bottom {
  padding-top: 10px;
}

table.list-table {
  border-collapse: collapse;
  border: 1px solid #ccc; 
}

table.list-tiny {
  font-size: x-small;
  border-collapse: collapse;
}

.list-table tr.list-header {
  background-color: #ffffff;
  color: inherit;
}

th.list-table, th.list-table-narrow, .list-table th {
  padding: 8px 16px;
  border-bottom: 3px solid #A0BDEB;
}

.list-table tr.even, .list-tiny tr.even {
  background-color: #ffffff;
  color: inherit;
}

.list-table tr.odd, .list-tiny tr.odd {
  background-color: #f0eff0;
  color: inherit;
}

td.list-table, td.list-table-narrow, .list-table td {
  padding: 8px 16px;
  border-bottom: 1px solid #A0BDEB;
}

td.list-table-narrow, th.list-table-narrow {
  padding-left: 4px;
  padding-right: 4px;
}

tr.last td {
  border-bottom: 3px solid #A0BDEB;
}

/* pagination ------------------------------------------ */
div.list-paginator-top {
 padding-bottom: 5px;
}

div.list-paginator-bottom {
  padding-top: 15px;
}

.list-paginator li {
  padding:5px;
}

.list-paginator li {
  border: 1px solid #f00;
  background-color: #fff;
  padding: 2px 4px;
  font-weight: bold;
  border: 1px solid #fff;
  color: inherit;
}

.list-paginator li a:hover {
  background-color: #e5e5e5;
  color: inherit;
}

.list-paginator li.current {
  background-color: #e5e5e5;
  border: 1px solid #999;
  color: inherit;
}

/* end pagination ------------------------------------------ */

/* list-filter ------------------------------------------ */

td.list-filter-pane {
  background-color: #eee;
  vertical-align: top;
  border: 1px solid #ccc;
  font-size: .9em;
  color: inherit;
}

.list-filter-header {
  font-weight: bold;
  border-top: 1px solid #999;

}

.list-filter { 
  font-size: x-small; 
  padding-left:10px;
}

tr.list-filter-selected {
  background-color: #bbb;
  color: inherit;
}

span.list-filter-selected { 
  font-weight: bold;
}

.list-filter-section { 
  font-size: x-small; 
  font-weight: bold; 
  background-color: #bbbbff; 
  padding-left: 4px; 
  padding-top: 4px; 
  padding-bottom: 4px; 
  margin-top: 0px; 
  margin-bottom: 8px;
}

div.list-inline-filter { 
  font-size: x-small; 
}

span.list-inline-filter { 
}

span.list-inline-filter-selected { 
  font-weight: bold;
}

a.list-inline-filter { 
}

td.list-list-pane {
  background-color: white;
  vertical-align: top;
  padding-left: 10px;
}

  th.list-table, th.list-table-narrow, .list-table th{
    border-bottom:3px solid #CCC;
  } 
    
  td.list-table, td.list-table-narrow, .list-table td{
    border-color:#CCC;
  } 
    
  table.list-table{
    border:1px solid #EEE;
  }
    
  tr.last td{
    border-bottom:1px solid #EEE;
    padding:8px 16px;
    width:715px;
  }

  #boxes H1{
  color:#999999;
  font-size:20px;
  font-weight:100;
  padding-top:10px;
  }

a.button, a.button-form{
  -moz-border-radius:5px; /* Para Firefox */
  -webkit-border-radius:5px; /*Para Safari e Chrome */
  border-radius:5px; /* Para Opera 10.5+*/
  cursor:pointer;
  /*display:inline-block;*/
  padding:5px 15px;
  text-decoration:none !important;
  }

a.button{  
  background:url(../images/bg_button.png) repeat-x;
  color:#000 !important;
  background-color: #EEE;
}

a.button:HOVER{
  color:#666 !important;
}

.button-g{
  background:url(../images/bg_button_g.png) repeat-x;
  -moz-border-radius:5px; /* Para Firefox */
  -webkit-border-radius:5px; /*Para Safari e Chrome */
  border-radius:5px; /* Para Opera 10.5+*/
  color:#FFF !important;
  display:inline-block;
  margin-bottom:20px;
  font-size:16px;
  padding:14px 20px 16px 20px;
  text-decoration:none !important;
  }
  
.button-g:HOVER{
  color:#CCC !important;
  } 
  
.button-form{ 
  background:url(../images/bg_button_form.png) repeat-x;
  color:#FFF !important;
}

.button-form:HOVER{
  color:#CCC !important;
  } 

</style>

<h1><?php print $title; ?></h1>
<div class="list-button-bar-top">
  <ul class="compact">
    <?php if(arg(1)): ?>
      <li><a href="javascript:history.go(-1)" class="button">Voltar</a></li>
    <?php endif; ?>
  </ul>
  <ul class="compact">
    <?php global $user; ?>
    <?php if($user->uid): ?>
      <li><a href="/tree/add/file<?php print ($mode == "paste") ? "/".$pid : ""; ?>" title="Enviar um arquivo para esta pasta" class="button">Adicionar Arquivo</a></li>
      <?php if(arg(1)) :?>
        <li><?php print l('Editar Pasta', 'tree/directory/edit/'.$pid, array('attributes' => array('class' => 'button'))) ?></li>
      <?php endif; ?>
      <li><a href="/tree/add/directory<?php print ($mode == "paste") ? "/".$pid : ""; ?>" title="Criar nova pasta" class="button">Nova Pasta</a></li>
    <?php endif; ?>
  </ul>
</div>

<div class="list-button-bar-top">
  <?php print $descricao; ?>
</div>

<table class="list-table" cellpadding="3" cellspacing="1" summary="Data for contents_75509">

  <thead>
    <tr class="list-header">
      <th class="list-table-narrow" align="center" id="contents_75509_checkbox">
        <input type="checkbox" name="_dummy" onclick="" onkeypress="" title="Marcar/Desmarcar todos as fileiras">
      </th>
      <th class="list-table" id="contents_75509_type">
        <a href="" title="">Tipo</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
      </th>
      <th class="list-table" id="contents_75509_name">
        <a href="" title="">Nome</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
      </th>
      <th class="list-table" id="contents_75509_content_size_pretty">
        <a href="" title="">Arquivo</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
      </th>
      <th class="list-table" id="contents_75509_last_modified_pretty">
        <a href="" title="">Última Modif.</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
      </th>
      <th class="list-table" id="contents_75509_properties_link">
      </th>
    </tr>
  </thead>
  <tbody>
    <?php $data = FALSE; ?>
    <?php for($i=0;$i<count($tipo);$i++): ?>
      <?php $data = TRUE; ?>
      <tr class="<?php print ($i % 2 == 0) ? 'odd last' : 'even last'; ?>">
        <td class="list-table-narrow" align="center" headers="contents_75509_checkbox">
          <input type="checkbox" name="object_id" value="855447" id="" title="Marque/Desmarque essa fileira e selecione uma ação para executar abaixo">
        </td>
        <td class="list-table" headers="contents_75509_type">
          <?php if($tipo[$i] != "Pasta"): ?>
            <img src="https://cdn1.iconfinder.com/data/icons/simplicio/32x32/file_add.png" style="border: 0;" alt="<?php print $tipo[$i]; ?>">
          <?php else: ?>
            <img src="http://www.redenitce.com.br/img/comum/pasta.png" style="border: 0;" alt="Pasta">
          <?php endif; ?>
          <?php print $tipo[$i]; ?>
        </img>
      </td>
      <td class="list-table" headers="contents_75509_name">
        <?php print l($nome[$i], ($tipo[$i] != "Pasta") ? file_create_url(file_load($ids[$i])->uri) : $ids[$i]); ?></a><br><br>
      </td>
      <td class="list-table" headers="contents_75509_content_size_pretty">
        <?php print $tamanho[$i]; ?>
      </td>
      <td class="list-table" headers="contents_75509_last_modified_pretty">
        <?php print $atualizacao[$i]; ?>
      </td>
      <td class="list-table" headers="contents_75509_properties_link">
        <?php print ($tipo[$i] != "Pasta") ? l(t('Propriedades'), "tree/info/file/$ids[$i]") : ''; ?>
      </td>
    </tr>
  <?php endfor; ?>
  <?php if(!$data): ?>
    <tr class="list-odd last">
      <td colspan="6">
        Não há dados.
      </td>
    </tr>
  <?php endif; ?>
</tbody>
</table>
<p> </p>
