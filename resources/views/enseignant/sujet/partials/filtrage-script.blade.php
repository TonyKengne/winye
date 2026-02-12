<script>
    const campusSelect      = document.getElementById('campusSelect');
    const cursusSelect      = document.getElementById('cursusSelect');
    const departementSelect = document.getElementById('departementSelect');
    const filiereSelect     = document.getElementById('filiereSelect');
    const semestreSelect    = document.getElementById('semestreSelect');
    const matiereSelect     = document.getElementById('matiereSelect');

    const cursusData        = @json($cursuses);
    const departementsData  = @json($departements);
    const filieresData      = @json($filieres);
    const matieresData      = @json($matieres);

    function resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    function refreshMatieres() {
        resetSelect(matiereSelect, '-- Sélectionner une matière --');

        matieresData.forEach(m => {
            let ok = true;

            if (semestreSelect.value && m.semestre != semestreSelect.value) ok = false;

            if (filiereSelect.value) {
                ok = m.filieres.some(f => f.id == filiereSelect.value) ? ok : false;
            }

            if (ok) {
                matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
            }
        });
    }

    campusSelect.addEventListener('change', () => {
        resetSelect(cursusSelect, '-- Choisir un cursus --');
        resetSelect(departementSelect, '-- Choisir un département --');
        resetSelect(filiereSelect, '-- Choisir une filière --');

        cursusData
            .filter(c => c.campus_id == campusSelect.value)
            .forEach(c => cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`);

        refreshMatieres();
    });

    cursusSelect.addEventListener('change', () => {
        resetSelect(departementSelect, '-- Choisir un département --');
        resetSelect(filiereSelect, '-- Choisir une filière --');

        departementsData
            .filter(d => d.cursus_id == cursusSelect.value)
            .forEach(d => departementSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`);

        refreshMatieres();
    });

    departementSelect.addEventListener('change', () => {
        resetSelect(filiereSelect, '-- Choisir une filière --');

        filieresData
            .filter(f => f.departement_id == departementSelect.value)
            .forEach(f => filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`);

        refreshMatieres();
    });

    filiereSelect.addEventListener('change', refreshMatieres);
    semestreSelect.addEventListener('change', refreshMatieres);

    refreshMatieres();
</script>
