<?php
include('config.php');

// Verifica as sessões não enviadas dentro do prazo
$query = "SELECT sessao.id, sessao.aluno_id, sessao.professor_id, aluno.nome AS aluno_nome, professor.email AS professor_email 
          FROM sessao 
          INNER JOIN aluno ON sessao.aluno_id = aluno.id
          INNER JOIN professor ON sessao.professor_id = professor.id
          WHERE sessao.status = 'pendente' AND TIMESTAMPDIFF(HOUR, sessao.data_horario, NOW()) > 48";

$result = mysqli_query($con, $query);

while ($sessao = mysqli_fetch_array($result)) {
    // Enviar notificação ao professor
    $email = $sessao['professor_email'];
    $assunto = "Notificação de Sessão Não Enviada";
    $mensagem = "O aluno {$sessao['aluno_nome']} não enviou a sessão dentro de 48 horas.";
    mail($email, $assunto, $mensagem);

    // Atualiza a notificação no banco de dados
    $sessao_id = $sessao['id'];
    mysqli_query($con, "UPDATE sessao SET professor_notificado = 1 WHERE id = $sessao_id");
}
?>