<style type="text/css">

.button, .button-form{
  -moz-border-radius:5px; /* Para Firefox */
  -webkit-border-radius:5px; /*Para Safari e Chrome */
  border-radius:5px; /* Para Opera 10.5+*/
  cursor:pointer;
  /*display:inline-block;*/
  padding:5px 15px;
  text-decoration:none !important;
  }

.button{  
  background:url(../images/bg_button.png) repeat-x;
  color:#000 !important;

}

.button:HOVER{
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

</style>

<h1><?php print $title; ?></h1>
<div class="list-button-bar-top">
  <ul class="compact">
    <li><a href="javascript:history.go(-1)" class="button">Voltar</a></li>
  </ul>
  <ul class="compact">
    <?php global $user; ?>
    <?php if($user->uid): ?>
      <li><?php print l('Editar', 'tree/file/edit/'.$file->fid, array('attributes' => array('class' => 'button'))) ?></li>
        <li>-</li>
        <li><?php print l('Excluir', 'tree/file/delete/'.$file->fid, array('attributes' => array('class' => 'button'))) ?></li>
    <?php endif; ?>
  </ul>
  </div>
  <table class="list-table table" cellpadding="3" cellspacing="1" summary="Data for contents_75509">
    <thead>
      <tr class="list-header">
        <th class="list-table" id="contents_75509_type">
          <a href="" title="">Título</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
        </th>
        <th class="list-table" id="contents_75509_type">
          <a href="" title="">Autor</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
        </th>
        <th class="list-table" id="contents_75509_name">
          <a href="" title="">Arquivo</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
        </th>
        <th class="list-table" id="contents_75509_content_size_pretty">
          <a href="" title="">Tipo</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
        </th>
        <th class="list-table" id="contents_75509_last_modified_pretty">
          <a href="" title="">Última Modificação</a> <img src="http://upload.wikimedia.org/wikipedia/commons/f/f5/Sort_both_small.svg" alt="not ordered" style="border:0">
        </th>
      </tr>
    </thead>
    <tbody>
      <tr class="odd last">
        <td class="list-table" headers="contents_75509_type">
          <img src="https://cdn1.iconfinder.com/data/icons/simplicio/32x32/file_add.png" style="border: 0;" alt="<?php print $title; ?>">
            <?php print $title; ?>
          </img>
      </td>
      <td class="list-table" headers="contents_75509_name">
        <?php print user_load($file->uid)->name ?>	
      </td>
      <td class="list-table" headers="contents_75509_content_size_pretty">
        <?php print $file->filesize ?> 
      </td>
      <td class="list-table" headers="contents_75509_last_modified_pretty">
        <?php print $file->filemime ?>
      </td>
      <td class="list-table" headers="contents_75509_properties_link">
        <?php print date("d/m/Y H:i:s", $file->timestamp) ?>
      </td>
    </tr>
  </tbody>
</table>
<p> </p>