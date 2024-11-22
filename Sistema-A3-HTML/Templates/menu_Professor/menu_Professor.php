<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/main.css">
    <title>Painel do Aluno</title>
</head>
<body>

<!-- Incluindo a navbar -->
<?php include 'navbar.php'; ?>

<!-- Filtro de alunos -->
<div class="filter-container">
    <form class="filter-form">
        <div class="filter-item name-filter">
            <input type="text" id="name-search" placeholder="Buscar aluno" onkeyup="filterName()" />
        </div>
        <div class="filter-item ra-filter">
            <input type="number" id="student-ra-search" placeholder="Buscar por RA" onkeyup="filterByRA()" />
        </div>
    </form>
</div>

<!-- Lista de alunos -->
<div class="main-content">
    <table id="list-table">
        <thead>
            <tr>
                <th>Nome do Aluno</th>
                <th>RA</th>
            </tr>
        </thead>
        <tbody id="list">
            <tr onclick="goToPage(0)">
                <td>João da Silva</td>
                <td>9423</td>
            </tr>
            <tr onclick="goToPage(1)">
                <td>Ana Pereira</td>
                <td>9422</td>
            </tr>
            <tr onclick="goToPage(2)">
                <td>Marcos Lima</td>
                <td>9421</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Funções de JavaScript
    function goToPage(index) {
        window.location.href = `menu_Professor_Aluno.php?id=${index}`;
    }

    function filterName() {
        const searchInput = document.getElementById('name-search').value.toLowerCase();
        const rows = document.querySelectorAll('#list tr');
        
        rows.forEach(row => {
            const listName = row.cells[0].innerText.toLowerCase();
            row.style.display = listName.includes(searchInput) ? '' : 'none';
        });
    }

    function filterByRA() {
        const raInput = document.getElementById('student-ra-search').value;
        const rows = document.querySelectorAll('#list tr');
        
        rows.forEach(row => {
            const studentRA = row.cells[1].innerText;
            row.style.display = studentRA.includes(raInput) ? '' : 'none';
        });
    }
</script>

</body>
</html>
