<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/main.css">
    <title>Painel do ADM</title>
</head>
<body>

<!-- Incluindo a navbar -->
<?php include 'navbar.php'; ?>

<!-- Filtro de profesores -->
<div class="filter-container">
    <form class="filter-form">
        <div class="filter-item name-filter">
            <input type="text" id="name-search" placeholder="Buscar professor" onkeyup="filterName()" />
        </div>
        <div class="filter-item email-filter">
            <input type="text" id="porfessor-email-search" placeholder="Buscar por Email" onkeyup="filterByEmail()" />
        </div>
    </form>
</div>

<!-- Lista de profesores -->
<div class="main-content">
    <table id="list-table">
        <thead>
            <tr>
                <th>Nome do Professor</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="list">
            <tr onclick="goToPage(0)">
                <td>João da Silva</td>
                <td>joaodasilva@gmail.com</td>
            </tr>
            <tr onclick="goToPage(1)">
                <td>Ana Pereira</td>
                <td>anapereira@gmail.com.br</td>
            </tr>
            <tr onclick="goToPage(2)">
                <td>Marcos Lima</td>
                <td>marcoslima@hotmail.com.br</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Função para redirecionar para a página do professor
    function goToPage(index) {
        // Aqui você pode colocar a lógica para redirecionar para outra página com as informações do professor
        window.location.href = `menu_ADM_Professor.php?id=${index}`;
    }

    // Função para filtrar os profesores conforme o que é digitado
    function filterName() {
    const searchInput = document.getElementById('name-search').value.toLowerCase();
    const rows = document.querySelectorAll('#list tr');
    
    rows.forEach(row => {
        const listName = row.cells[0].innerText.toLowerCase();
        row.style.display = listName.includes(searchInput) ? '' : 'none';
    });
}

function filterByEmail() {
    const emailInput = document.getElementById('porfessor-email-search').value;
    const rows = document.querySelectorAll('#list tr');
    
    rows.forEach(row => {
        const professorEmail = row.cells[1].innerText;
        row.style.display = professorEmail.includes(emailInput) ? '' : 'none';
    });
}
</script>

</body>
</html>