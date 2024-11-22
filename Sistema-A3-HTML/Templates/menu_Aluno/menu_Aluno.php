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

<!-- Filtro de Pacientes -->
<div class="filter-container">
    <form class="filter-form">
        <div class="filter-item name-filter">
            <input type="text" id="name-search" placeholder="Buscar paciente" onkeyup="filterName()" />
        </div>
        <div class="filter-item">
            <button type="button" id="sorting-button" onclick="sortDate()">Alternar Ordem de Sessão</button>
        </div>
    </form>
</div>

<!-- Lista de Pacientes -->
<div class="main-content">
    <table id="list-table">
        <thead>
            <tr>
                <th>Nome do Paciente</th>
                <th>Última Sessão</th>
            </tr>
        </thead>
        <tbody id="list">
            <tr onclick="goToPage(0)">
                <td>João da Silva</td>
                <td>10/11/2024</td>
            </tr>
            <tr onclick="goToPage(1)">
                <td>Ana Pereira</td>
                <td>15/11/2024</td>
            </tr>
            <tr onclick="goToPage(2)">
                <td>Marcos Lima</td>
                <td>18/11/2024</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Função para redirecionar para a página do paciente
    function goToPage(index) {
        window.location.href = `patient_page.html?id=${index}`;
    }

    // Função para filtrar os pacientes conforme o que é digitado
    function filterName() {
        const searchInput = document.getElementById('name-search').value.toLowerCase();
        const rows = document.querySelectorAll('#list tr');
        
        rows.forEach(row => {
            const listName = row.cells[0].innerText.toLowerCase();
            if (listName.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    let isDescending = true; // Define a ordem inicial como descendente (mais recente primeiro).

    // Função para ordenar as datas
    function sortDate() {
        const rows = Array.from(document.querySelectorAll('#list tr'));

        rows.sort((a, b) => {
            const [dayA, monthA, yearA] = a.cells[1].innerText.split('/');
            const [dayB, monthB, yearB] = b.cells[1].innerText.split('/');

            const dateA = new Date(`${yearA}-${monthA}-${dayA}`);
            const dateB = new Date(`${yearB}-${monthB}-${dayB}`);

            return isDescending ? dateB - dateA : dateA - dateB;
        });

        const tbody = document.getElementById('list');
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));

        isDescending = !isDescending;
    }

    document.addEventListener('DOMContentLoaded', () => {
        sortDate();
        isDescending = true;
    });
</script>

</body>
</html>
