<?php

function files_view()
{
  $id = $tipo = $nome = $tamanho = $atualizacao = array();

  $query = db_query(
    "SELECT tf.fid, tf.title, tf.updated FROM tb_file tf
      WHERE tf.id NOT 
      IN (SELECT fid FROM tb_directory_file WHERE fid IS NOT NULL)"
  );
  
  foreach($query as $res){
    $id[]   = $res->fid;
    $tipo[] = file_load($res->fid)->filemime;
    $nome[] = $res->title;
    $tamanho[] = bytesToSize(file_load($res->fid)->filesize);
    $atualizacao[] = date("d/m/Y H:i", $res->updated);
  }

  $query = db_query("SELECT * FROM tb_directory WHERE pid_ref = 0");

  foreach($query as $res)
  {
    $itens = db_query("SELECT COUNT(pid) FROM tb_directory_file WHERE pid = :pid", 
      array(':pid' => $res->id))->fetchField();

    $id[]   = $res->id; 
    $tipo[] = "Pasta";
    $nome[] = $res->title;
    $tamanho[] = $itens . " items(s)";
    $atualizacao[] = date("d/m/Y H:i", $res->created);
  }

  return theme(getThemeByUserAccess('files'), array(
    'title' => 'Arquivos', 
    'mode' => 'view', 
    'ids' => $id, 
    'tipo' => $tipo, 
    'nome' => $nome, 
    'tamanho' => $tamanho, 
    'atualizacao' => $atualizacao
  ));
}

function files_info_view($fid)
{
  $file = db_query("SELECT * FROM file_managed WHERE fid = :fid", 
    array(':fid' => $fid))->fetchObject();
  $title = db_query("SELECT title FROM tb_file WHERE fid = :fid", 
    array(':fid' => $fid))->fetchField();
  
  $file->filesize = bytesToSize($file->filesize);

  return theme(getThemeByUserAccess('files_info'), array('file' => $file, 'title' => $title));
}

function directory_file_view($pid)
{
  try
  {
    $pid = trim(strip_tags(addslashes($pid)));

    $query = db_query("SELECT * FROM tb_directory_file WHERE pid = :pid", array(":pid" => $pid));

    $id = $tipo = $nome = $tamanho = $atualizacao = array();
    
    $info = db_query("SELECT title, description FROM tb_directory WHERE id = :pid", array(":pid" => $pid))->fetchObject();

    foreach($query as $fid)
    {
      $query = db_query("SELECT * FROM tb_file WHERE id = :id", array(':id' => $fid->fid));

      foreach($query as $res)
      {
        $id[] = $res->fid;
        $tipo[] = file_load($res->fid)->filemime;
        $nome[] = $res->title;
        $tamanho[] = bytesToSize(file_load($res->fid)->filesize);
        $atualizacao[] = date("d/m/Y H:i", $res->updated);
      }     
    }

    $query = db_query("SELECT * FROM tb_directory WHERE pid_ref = :pid", array(':pid' => $pid));

    foreach($query as $res)
    {
      $itens = db_query("SELECT COUNT(pid) FROM tb_directory_file WHERE pid = :pid", array(':pid' => $res->id))->fetchField();

      $id[]   = $res->id;
      $tipo[] = "Pasta";
      $nome[] = $res->title;
      $tamanho[] = $itens . " items(s)";
      $atualizacao[] = date("d/m/Y H:i", $res->created);
    }
  } 
  catch(Exception $e)
  {
    drupal_goto('tree');
  }

  return theme(getThemeByUserAccess('files'), array(
    'title' => $info->title, 
    'descricao' => $info->description,
    'mode' => 'paste', 
    'ids' => $id, 
    'tipo' => $tipo, 
    'nome' => $nome,
    'tamanho' => $tamanho, 
    'atualizacao' => $atualizacao, 
    'pid' => $pid
  ));
}

function file_delete_form($form, &$form_state)
{
  $form['opcao'] = array(
    '#type' => 'radios',
    '#options' => array('sim' => t('SIM'), 'nao' => t('NÃO')),
    '#title' => t('<div class="form-item-wrapper">
      <span class="form-label">Deseja realmente excluir este arquivo?</span>
    </div>'),
    );

  $form['fid'] = array(
    '#type' => 'hidden',
    '#value' => (arg(3)) ? arg(3) : 0,
    );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('       OK       '),
    '#prefix' => '<div class="form-button">',
    '#suffix' => '</div></div>',
    );

  return $form; 
}

function file_delete_form_validate($form, &$form_state)
{
  if(empty($form_state['values']['opcao']))
    form_set_error('opcao', 'Selecione uma opção antes de prosseguir!');
}

function file_delete_form_submit($form, &$form_state)
{
  try
  {
    if($form_state['values']['fid'] != "0" && $form_state['values']['opcao'] == "sim")
    {
      $fid = $form_state['values']['fid'];

      $file = file_load($fid);
      $file = ($file) ? drupal_realpath($file->uri) : $file;

      $id = db_query("SELECT id FROM tb_file WHERE fid = :fid", array(':fid' => $fid))->fetchField();

      db_query("DELETE FROM tb_directory_file WHERE fid = :fid", 
        array(':fid' => $id));
      db_query("DELETE FROM file_managed WHERE fid = :fid", 
        array(':fid' => $fid));
      db_query("DELETE FROM tb_file WHERE fid = :fid", 
        array(':fid' => $fid));

      if(file_exists($file)) @unlink($file);

      drupal_set_message('Arquivo excluido com sucesso!');
    } else {
      form_set_error('error', 'Você cancelou a exclusão deste arquivo.');
    }
  }
  catch(Exception $e)
  {
    form_set_error('error', 'Não foi possível excluir este arquivo, por favor tente novamente.');
  }

  drupal_goto('tree');
}

function file_update_form($form, &$form_state)
{
  $file = db_query(
    "SELECT tf.title, tf.description FROM tb_file tf 
      LEFT JOIN file_managed fm 
      ON fm.fid = tf.fid 
      WHERE tf.fid = :fid", array(':fid' => arg(3)))->fetchObject();

  $form = array();

  $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Título</span></div>'),
    '#prefix' => '<h1>Editar arquivo</h1><p></p><div class="margin-form">',
    '#default_value' => $file->title,
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Descrição</span></div>'),
    '#cols' => 40,
    '#rows' => 5,
    '#default_value' => $file->description,
  );

  $form['fid'] = array(
    '#type' => 'hidden',
    '#value' => (arg(3)) ? arg(3) : 0,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('   Atualizar   '),
    '#prefix' => '<div class="form-button">',
    '#suffix' => '</div></div>',
  );

  return $form;
}

function file_update_form_validate($form, &$form_state)
{
  if(!$form_state['values']['title'])
    form_set_error('title', 'Digite um título para este arquivo!');
}

function file_update_form_submit($form, &$form_state)
{
  if($form_state['values']['fid'] != "0")
  {
    try
    {
      db_query(
        'UPDATE tb_file SET title = :title, description = :desc WHERE fid = :fid', array(
            ':title' => $form_state['values']['title'], 
            ':desc' => $form_state['values']['description'],
            ':fid' => $form_state['values']['fid']
      ));

      db_query('UPDATE file_managed SET timestamp = :time WHERE fid = :fid', array(
        ':time' => time(),
        ':fid' => $form_state['values']['fid']
      ));

      drupal_set_message('Arquivo atualizado com sucesso!');
    }
    catch(Exception $e)
    {
      form_set_error('error', 'Não foi possível atualizar este arquivo, tente novamente!');
    }
  }

  drupal_goto(sprintf("tree/info/file/%s", $form_state['values']['fid']));
}

function files_form($form, &$form_state)
{
  $form = array();

  $form['file'] = array(
    '#type' => 'file',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Fazer Upload de um arquivo</span>'),
    '#description' => t('</div>Selecione um arquivo do seu computador para enviar ao servidor'),
    '#prefix' => '<h1>Fazer Upload de um Novo Arquivo</h1><p></p><div class="margin-form">',
  );

  $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Título</span></div>'),
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Descrição</span></div>'),
    '#cols' => 40, 
    '#rows' => 5,
  );

  $form['pid'] = array(
    '#type' => 'hidden',
    '#value' => (arg(3)) ? arg(3) : 0,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('       OK       '),
    '#prefix' => '<div class="form-button">',
    '#suffix' => '</div></div>',
  );

  return $form;
}

function files_form_validate($form, &$form_state)
{
  $file = file_save_upload('file', array(
    'file_validate_extensions' => array('jpg jpeg gif png txt doc xls pdf ppt pps odt ods odp docx avi mp3 mp4 ogg mpg mpeg csv pptx docx'),
  ));

  if ($file){
    $uri = db_query(
      "SELECT uri FROM tb_directory
        WHERE id = :id", array(':id' => $form_state['values']['pid']
    ))->fetchField();
    
    $dir = (!empty($uri)) ? $uri : "public://uploads";

    if ($file = file_move($file, $dir)){
      $form_state['values']['file'] = $file;
    } else {
      form_set_error('file', t('Erro ao escrever na pasta de upload do site, por favor entre em contato com o administrador.'));
    }
  } else {
    form_set_error('file', t('Nenhum arquivo foi selecionado'));
  }

  if(!$form_state['values']['title'])
    form_set_error('title', t('Digite um título para este arquivo.'));
}

function files_form_submit($form, &$form_state)
{
  try
  {
    $file = $form_state['values']['file'];
    unset($form_state['values']['file']);
    $file->status = FILE_STATUS_PERMANENT;
    file_save($file);

    $id = db_insert('tb_file')->fields(array(
      'title' => $form_state['values']['title'],
      'description' => $form_state['values']['description'],
      'updated' => $file->timestamp,
      'fid' => $file->fid
    ))->execute();

    if($form_state['values']['pid'] && $id)
    {
      db_query('INSERT INTO tb_directory_file (pid, fid) VALUES (:pid, :fid)', array(
        ':pid' => (int)$form_state['values']['pid'], 
        ':fid' => $id
      ));

      drupal_set_message(t('O arquivo <strong>@filename</strong> foi enviado com sucesso!', array(
        '@filename' => $file->filename)));
    }


    drupal_goto('tree');
  } 
  catch(Exception $e) 
  {
    form_set_error('file', $e->getMessage()  . $form_state['values']['pid']. $id.'Não foi possível salvar este arquivo, tente novamente.');
  }
}

function paste_form($form, &$form_state)
{
  $form = array();

  $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Título:</span></div>'),
    '#prefix' => '<h1>Criar Nova Pasta</h1><p></p><div class="margin-form">',
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Descrição:</span></div>'),
    '#cols' => 40,
    '#rows' => 5,
  );

  $form['pid'] = array(
    '#type' => 'hidden',
    '#value' => (arg(3)) ? arg(3) : 0,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('       OK       '),
    '#prefix' => '<div class="form-button">',
    '#suffix' => '</div></div>',
  );

  return $form;
}

function paste_form_validate($form, &$form_state)
{
  if(!$form_state['values']['title'])
    form_set_error('title', 'Digite um título para esta nova pasta.');
}

function paste_form_submit($form, &$form_state)
{
  try
  {
    $uri = db_query("SELECT uri FROM tb_directory WHERE id = :id", array(
      ':id' => $form_state['values']['pid']
    ))->fetchField();

    $uri = (!empty($uri)) ? $uri : "public://uploads";

    $dir = $uri . '/' . strtolower($form_state['values']['title']);

    file_prepare_directory($dir, FILE_CREATE_DIRECTORY);

    db_query(
      'INSERT INTO tb_directory (title, description, created, uri, pid_ref) 
        VALUES (:title, :desc, :created, :uri, :pid_ref)', array(
          ':title' => strtolower($form_state['values']['title']),
          ':desc'  => $form_state['values']['description'],
          ':created' => time(),
          ':uri' => $dir,
          ':pid_ref' => ($form_state['values']['pid'])
    ));

    drupal_set_message('Pasta criada com sucesso!');
  } 
  catch(Exception $e) 
  {
    form_set_error('title', 'Não foi possível criar esta nova pasta, tente novamente com outro nome.');
  }

  drupal_goto('tree'); 
}

function directory_update_form($form, &$form_state)
{
  $file = db_query(
    "SELECT td.title, td.description FROM tb_directory td 
      WHERE td.id = :id", array(':id' => arg(3)))->fetchObject();

  $form = array();

  $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Título</span></div>'),
    '#prefix' => '<h1>Editar diretório</h1><p></p><div class="margin-form">',
    '#default_value' => $file->title,
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('<div class="form-item-wrapper"><span class="form-label">Descrição</span></div>'),
    '#cols' => 40,
    '#rows' => 5,
    '#default_value' => $file->description,
  );

  $form['id'] = array(
    '#type' => 'hidden',
    '#value' => (arg(3)) ? arg(3) : 0,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('   Atualizar   '),
    '#prefix' => '<div class="form-button">',
    '#suffix' => '</div></div>',
  );

  return $form;
}

function directory_update_form_validate($form, &$form_state)
{
  if(!$form_state['values']['title'])
    form_set_error('title', 'Digite um título para este diretório!');
}

function directory_update_form_submit($form, &$form_state)
{
  if($form_state['values']['id'] != "0")
  {
    try
    {
      db_query(
        'UPDATE tb_directory SET title = :title, description = :desc WHERE id = :id', array(
            ':title' => $form_state['values']['title'], 
            ':desc' => $form_state['values']['description'],
            ':id' => $form_state['values']['id']
      ));

      drupal_set_message('Diretório atualizado com sucesso!');
    }
    catch(Exception $e)
    {
      form_set_error('error', 'Não foi possível atualizar este diretório, tente novamente!');
    }
  }

  drupal_goto(sprintf("tree/info/directory/%s", $form_state['values']['id']));
}

function bytesToSize($bytes, $precision = 1)
{  
  $kilobyte = 1024;
  $megabyte = $kilobyte * 1024;
  $gigabyte = $megabyte * 1024;
  $terabyte = $gigabyte * 1024;

  if (($bytes >= 0) && ($bytes < $kilobyte)) {
    return $bytes . ' B';

  } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
    return round($bytes / $kilobyte, $precision) . ' KB';

  } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
    return round($bytes / $megabyte, $precision) . ' MB';

  } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
    return round($bytes / $gigabyte, $precision) . ' GB';

  } elseif ($bytes >= $terabyte) {
    return round($bytes / $terabyte, $precision) . ' TB';
  } else {
    return $bytes . ' B';
  }
}

function getThemeByUserAccess($theme)
{
  return ($theme == 'files') 
    ? (user_access('administer') ? 'files_admin' : 'files_user')
    : (user_access('administer') ? 'files_info_admin' : 'files_info_user');
}
