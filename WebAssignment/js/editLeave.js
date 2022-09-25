//reset button keep employeee ID and employee Name
setMinimumDate();

const getTextArea = document.querySelector('#reason');
getTextArea.addEventListener("input", function (e) {
    console.log();
    countWords(e.target);
});

function countWords(textArea) {
    //console.log(textArea)
    let text = textArea.value;

    let numWords = 0;
    let countChar = 0;
    let currentCharacter = "";

    for (let i = 0; i < text.length; i++) {
        currentCharacter = text[i];
        countChar++;

        if (currentCharacter == " ") {
            numWords += 1;
        }
    }

    // Add 1 to make the count equal to the number of words
    numWords += 1;

    const errorMsg = document.querySelector(".error");
    const submitBtn = document.querySelector(".submit-btn");

    if (numWords >= 50 && !errorMsg) { //If error message not found
        //Set the attribute to become disabled to type
        textArea.setAttribute("maxlength", countChar);

        //Create a new error message
        const createP = document.createElement("p");
        createP.classList.add("error");
        createP.innerHTML = "You have exceeded the maximum number of words";
        document.getElementById("reason").after(createP);

        //Set the button to become disabled
        submitBtn.setAttribute("disabled", "disabled");
        submitBtn.style.backgroundColor = "#ccc";

    } else if (numWords <= 50 && errorMsg) {
        //remove the error message                           
        errorMsg.remove();
        textArea.removeAttribute("maxlength");
        submitBtn.removeAttribute("disabled");
        submitBtn.removeAttribute("style");

    }
}


function tableRowCtrl(){
    
const getTableRow = document.querySelector("tbody").children;
let getEditBtn = "";

for (let i = 0; i < getTableRow.length; i++) {
    //getEditBtn = getTableRow.item(i).querySelector(".table-edit-btn");
    getEditBtn = getTableRow.item(i);

    getEditBtn.addEventListener("click", function (e) {

        const status = e.target.parentElement.parentElement.children[6].innerHTML;
         if (status === "Pending") {
            const rowDate = e.target.parentElement.parentElement.children[2].innerHTML;
            const getReason = e.target.parentElement.parentElement.children[5].innerHTML;

            console.log(getReason);

            let startDate = rowDate.replace(/\s/g, '').substring(0, 10);
            let endDate = rowDate.replace(/\s/g, '').substring(16, rowDate.length);

            document.getElementById("startdate").value = startDate;
            document.getElementById("enddate").value = endDate;
            document.getElementById("reason").value = getReason;
        }
    });
}
}

//  To restrict past date
function setMinimumDate() {
    let date = new Date().toISOString().slice(0, 10);

    const startDateInput = document.getElementById('startdate');
    const endDateInput = document.getElementById('enddate');

    startDateInput.setAttribute('min', date);
    endDateInput.setAttribute('min', date);
}

function checkDateValid(){
    const startDateInput = document.getElementById('startdate');
    const endDateInput = document.getElementById('enddate');

    if(!startDateInput.value|| !endDateInput.value){
        return;
    }

    if(startDateInput.value > endDateInput.value){
        alert("The second date must be larger than the first date");
        endDateInput.value = "";
        return;
    }
    return;
}