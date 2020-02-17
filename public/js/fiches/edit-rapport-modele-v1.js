/**
 * Calcule la note courante pour la section donnee
 *
 * @param {int} indexSection
 */
function calculeNoteSection(indexSection)
{
    let note = 0.0;

    let section = document.getElementById(`section${indexSection}`);
    for(let i=0; i<section.childElementCount; i++)
    {
        let boutonsRadio = document.getElementsByName(`contenu[${indexSection}][${i}]`);
        for(let j=0; j<(boutonsRadio.length - 1); j++) // -1 car on a l'input hidden
        {
            let bouton = document.getElementById(`s${indexSection}c${i}rb${j}`);
            if(bouton.checked)
            {
                let enteteBouton = document.getElementById(`spanS${indexSection}C${j}`);
                note += parseFloat(enteteBouton.innerHTML);
                break;
            }
        }
    }

    return note;
}

/**
 *
 * @param {int} indexSection
 */
function majNoteSection(indexSection)
{
    let spanNoteSection = document.getElementById(`spanNoteS${indexSection}`);
    spanNoteSection.innerHTML = calculeNoteSection(indexSection);
    majNoteFinale()
}

function majNoteFinale()
{
    let note = 0;

    // Recuperation des notes des sections
    let containerSection = document.getElementById('container-sections');
    for(let i=0; i<containerSection.childElementCount; i++)
    {
        note += calculeNoteSection(i);
    }

    // Mise a jour graphique
    let spanNote = document.getElementById('spanNote');
    spanNote.innerText = note;
}
