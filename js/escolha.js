function mudaCargo(tipoV) {
    if (tipoV == "Aluno") {
        let divProf = document.getElementById("Curso");
        divProf.style.display = "block";
        divProf = document.getElementById("Ano");
        divProf.style.display = "block";
        divProf = document.getElementById("Turma");
        divProf.style.display = "block";
    } else {
        let divProf = document.getElementById("Curso");
        divProf.style.display = "none";
        divProf = document.getElementById("Ano");
        divProf.style.display = "none";
        divProf = document.getElementById("Turma");
        divProf.style.display = "none";
    }
}

function mudaCargo1(tipoV) {
    if (tipoV == "Aluno1") {
        let divProf = document.getElementById("Curso1");
        divProf.style.display = "block";
        divProf = document.getElementById("Ano1");
        divProf.style.display = "block";
        divProf = document.getElementById("Turma1");
        divProf.style.display = "block";
    } else {
        let divProf = document.getElementById("Curso1");
        divProf.style.display = "none";
        divProf = document.getElementById("Ano1");
        divProf.style.display = "none";
        divProf = document.getElementById("Turma1");
        divProf.style.display = "none";
    }
}


document.getElementById('CursoSelect').addEventListener('change', (event) => {
    const tipoV = event.target.value;

    if (tipoV == "Profissional") {
        let divProf = document.getElementById("TurmaProfissional");
        divProf.style.display = "block";
        divProf = document.getElementById("TurmaRegular");
        divProf.style.display = "none";
    }
    if (tipoV == "Regular") {
        let divProf = document.getElementById("TurmaProfissional");
        divProf.style.display = "none";
        divProf = document.getElementById("TurmaRegular");
        divProf.style.display = "block";
    }
    if (tipoV == "blank") {
        let divProf = document.getElementById("TurmaProfissional");
        divProf.style.display = "none";
        divProf = document.getElementById("TurmaRegular");
        divProf.style.display = "none";
    }
});



/*function registar(Cod_Equipamento, Quantidade) {
    $Cod_Equipamento = Cod_Equipamento;
    $Quantidade = Quantidade;
    window.location.href = "produtos.php";
    document.getElementById("quantidade").value + $Quantidade;
    document.getElementById("emprestados").value - $Quantidade;
}*/

/*function mudarCor() {
    document.getElementById('btnInformatica').style.backgroundColor = "black";
    // O mesmo para as outras tabelas
    document.getElementById(btnId).style.backgroundColor = "grey"; 
    //<button onclick="mudarCor("tabelaInformatica");">Informatica</button>
}*/