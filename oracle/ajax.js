const display = document.getElementById("num");
const display2 = document.getElementById("num2");
const submit = document.getElementById("submit");
const clear = document.getElementById("clear");
const select = document.getElementById("selection");
const btn = document.getElementById("btn");
const Ac = document.getElementById("ac");
const tableBody = document.getElementById("tableBody");
const save = document.getElementById("save");
const table = document.getElementById("filesTable");
const openBtn = document.getElementById("open");
const printBtn = document.getElementById("print");
var sendReq;
var recive;
function AddByClick(a){
    display.value+=a;
} 
function sendId(id){
    let newXhttp = new XMLHttpRequest();
    let newNum = prompt("Insert a new value");
   let newOperator = prompt("Insert a new operator");
   let updateValues = {"newNumber": newNum, "newOperator": newOperator, "id": id};
   let sendNew = JSON.stringify(updateValues);
   console.log(sendNew);
   newXhttp.onreadystatechange = function() {
    if (newXhttp.readyState == 4 && newXhttp.status == 200) {
        updatedInfo = JSON.parse(newXhttp.responseText);
        console.log(updatedInfo); 
        let updatedHtml = "";
        for (let i = 0 ; i < updatedInfo.length ; i++){
            let updatedNubmer = parseFloat(updatedInfo[i]['VALUE']).toFixed(select.value);
            let updatedOperator = updatedInfo[i]['OPERATOR'];
            let updatedResult = parseFloat(updatedInfo[i]['RESULT']).toFixed(select.value);
            display2.value= updatedResult;
            updatedHtml+= "<tr>";
            if (updatedOperator == "+"){
              
                updatedHtml+= '<td style= "color: black;">' + updatedNubmer + "</td>";
                updatedHtml+= '<td style= "color: black; text-align: center;">' + updatedOperator + "</td>";
                updatedHtml+= '<td style= "color: black;">' + updatedResult + "</td>";
                updatedHtml+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(updatedInfo[i]['ID'],'>') + "Edit" + "</button></td>";
            }else{
                updatedHtml+= '<td style= "color: red;">' + updatedNubmer + "</td>";
                updatedHtml+= '<td style= "color: red; text-align: center;">' + updatedOperator + "</td>";
                updatedHtml+= '<td style= "color: red;">' + updatedResult + "</td>";
                updatedHtml+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(updatedInfo[i]['ID'],'>') + "Edit" + "</button></td>";
            }
            updatedHtml+= "</tr>";
       } //for loop end
      tableBody.innerHTML = updatedHtml;

        }// if condition end
       
    }
    newXhttp.open("POST", "updateOrc.php");
    newXhttp.send(sendNew);
    }
    


function AddByKeyboard(event){
    var keyValue = event.key;
    var check = ["+", "-", "0", "1", "2", "3", "4", "5", "6", '7', '8', '9', "Shift", ".", 'Backspace', 'ArrowRight', 'Enter'];
    if(check.includes(keyValue)){
        if (keyValue == "Shift"){
            display.value+="00";
        }else if(keyValue == "Backspace"){
           display.value = display.value.substring(0,display.value.length-1);
        }else if(keyValue == "ArrowRight"){
            display.value="";
        }else if(keyValue == "Enter"){
            let xhr = new XMLHttpRequest();
            let number = display.value;
            let send = JSON.stringify([number, select.value]);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                   recive =JSON.parse(xhr.responseText);
                    display2.value =parseFloat(recive[1]['submission']).toFixed(select.value);
                    let html = "";
                   for(let a =0 ; a < recive[0].length; a++){
                    let valueHistory = parseFloat(recive[0][a]['VALUE']).toFixed(select.value); 
                    let operarorHistory = recive[0][a]['OPERATOR'];
                    let resultHistory = parseFloat(recive[0][a]['RESULT']).toFixed(select.value);
                      html+= "<tr>";
                      if (operarorHistory == "+"){
                        
                      html+= '<td style= "color: black;">' + valueHistory + "</td>";
                      html+= '<td style= "color: black; text-align: center;">' + operarorHistory + "</td>";
                      html+= '<td style= "color: black;">' + resultHistory + "</td>";
                      html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(recive[0][a]['ID'],'>') + "Edit" + "</button></td>";
                      }else{
                       html+= '<td style= "color: red;">' + valueHistory + "</td>";
                       html+= '<td style= "color: red; text-align: center;">' + operarorHistory + "</td>";
                       html+= '<td style= "color: red;">' + resultHistory + "</td>";
                       html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(recive[0][a]['ID'],'>') + "Edit" + "</button></td>";
                      }
                      html+= "</tr>";
                 }
                tableBody.innerHTML = html;
                }
              };
            xhr.open("POST", "calculationOrc.php");
            xhr.send(send);
            display.value = "";
        }
        else{
           display.value+=keyValue;
        }
        
    }else{
        display.value+=""; 
    }}
    function Backbtn(){
        display.value = display.value.substring(0,display.value.length-1);
    };
    clear.addEventListener("click", function(){
        display.value="";
    }); 
    submit.addEventListener("click", function(){
        let xhr = new XMLHttpRequest();
        let number = display.value;
        let send = JSON.stringify([number, select.value]);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                recive =JSON.parse(xhr.responseText);
                display2.value =parseFloat(recive[1]['submission']).toFixed(select.value);
                    let html = "";
                   for(let a =0 ; a < recive[0].length; a++){
                      let valueHistory =  parseFloat(recive[0][a]['VALUE']).toFixed(select.value); 
                      let operarorHistory = recive[0][a]['OPERATOR'];
                      let resultHistory = parseFloat(recive[0][a]['RESULT']).toFixed(select.value);
                      html+= "<tr>";
                      if (operarorHistory == "+"){
                      html+= '<td style= "color: black">' + valueHistory + "</td>";
                      html+= '<td style= "color: black; text-align: center;">' + operarorHistory + "</td>";
                      html+= '<td style= "color: black;">' + resultHistory + "</td>";
                      html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(recive[0][a]['ID'],'>') + "Edit" + "</button></td>";
                      }else{
                       html+= '<td style= "color:red;">' + valueHistory + "</td>";
                       html+= '<td style= "color:red; text-align: center;">' + operarorHistory + "</td>";
                       html+= '<td style= "color: red;">' + resultHistory + "</td>";
                       html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(recive[0][a]['ID'],'>') + "Edit" + "</button></td>";
                      }
                      html+= "</tr>";
                 }
                  tableBody.innerHTML = html;
                
            }
          };
        console.log (send);
        console.log(xhr.responseText);
        xhr.open("POST", "calculationOrc.php");
        xhr.send(send);
        display.value="";
    });
    btn.addEventListener("click", function(){
        if (select.value == "Frc") {
            display2.value= parseFloat(recive[1]['submission']).toFixed(0); 
        }
        else if (select.value == 0){
            display2.value= parseFloat(recive[1]['submission']).toFixed(0);
           
        } else if (select.value == 1){
            display2.value= parseFloat(recive[1]['submission']).toFixed(1);
           
        } else if (select.value == 2){
            display2.value= parseFloat(recive[1]['submission']).toFixed(2);
           
        } else if (select.value == 3){
            display2.value= parseFloat(recive[1]['submission']).toFixed(3);
           
        } else{
            display2.value= parseFloat(recive[1]['submission']).toFixed(4);
           
        }
    })
    Ac.addEventListener("click", function(){
        let confirmation = confirm("Do you want to save these procedures?");
        console.log(confirmation);
        if(confirmation == true){
            let fileName = prompt("Enter file's name:");
        if(fileName == null){
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if (xhttp.readyState == 4 && xhttp.status == 200){
                    let order = JSON.parse(xhttp.responseText);
                    if(order["confirm"] == 1){
                        display2.value ="0";
                        display.value ="0";
                        tableBody.innerHTML = "";
                       }
                }
            }   
        
   
    let erase = 1;
    let DeleteObj = [JSON.stringify(erase)];
    xhttp.open("POST", "ClearOrc.php");
    xhttp.send(DeleteObj);  
            alert("Save cancelled");
        }else if(fileName == " "|| fileName == ""){
            alert ("Insert another name with no spaces in the beginning");
        }else{
            let xml = new XMLHttpRequest();
            xml.onreadystatechange = function() {
                if (xml.readyState == 4 && xml.status == 200) {
                  if(xml.responseText == "This name already exists"){
                      alert("This name already exists, try another name");
                  }else{
                    display.value = "";
                    display2.value = "";
                    tableBody.innerHTML = "";
                    alert("Saved");
                  }
                }
              };
            xml.open("POST", "saveOrc.php");
            xml.send(JSON.stringify(fileName));
        }
        }else{
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if (xhttp.readyState == 4 && xhttp.status == 200){
                    let order = JSON.parse(xhttp.responseText);
                    if(order["confirm"] == 1){
                        display2.value ="0";
                        display.value ="0";
                        tableBody.innerHTML = "";
                       }
                }
            }   
        
   
    let erase = 1;
    let DeleteObj = [JSON.stringify(erase)];
    xhttp.open("POST", "ClearOrc.php");
    xhttp.send(DeleteObj);  
        }
      
    });
    save.addEventListener("click", function(){
        let fileName = prompt("Enter file's name:");
        if(fileName == null){
            alert("Save cancelled");
        }else if(fileName == " "|| fileName == ""){
            alert ("Insert another name with no spaces in the beginning");
        }else{
            let xml = new XMLHttpRequest();
            xml.onreadystatechange = function() {
                if (xml.readyState == 4 && xml.status == 200) {
                  if(xml.responseText == "This name already exists!! Try another one!!"){
                      alert("This name already exists, try another name");
                  }else{
                    display.value = "";
                    display2.value = "";
                    tableBody.innerHTML = "";
                    alert("Saved");
                  }
                }
              };
            xml.open("POST", "saveOrc.php");
            xml.send(JSON.stringify(fileName));
        }
    });
    printBtn.addEventListener("click", function(){
        let printreq = new XMLHttpRequest();
        let decimal = {"decimal": select.value};
        let sendDeci = JSON.stringify(decimal);
        console.log(sendDeci);
        printreq.open("POST", "printOrc.php");
        printreq.send(sendDeci);
           location.href = "printOrc.php";
        
       // location.href ='printPage.php'
    });
    function openWin(){
        window.open("openFormOrc.php","", "width=700,height=700");
       // location.href = "openFile.php";
    };
   /* function getVal(x){
        let serverReq = new XMLHttpRequest();
        console.log(x.value);
        let fileName = JSON.stringify(x.value);
        serverReq.open("POST", "openSaved.php");
        serverReq.send(fileName); 
        sendReq = 1;
        //console.log(sendReq);
        //alert("Refresh to view opened file"); 
        function refreshParent() {
            window.opener.location.reload();
           
        }
        
        window.onunload = refreshParent;
        window.close;
      }*/
      async function getData2(){
          const vari = await fetch("test.php");
          const data = await vari.json();
          let html = "";
          for(let i =0 ; i < data.length; i++){
            let returnedValue = parseFloat(data[i]['VALUE']).toFixed(select.value); 
            let returnedOperator = data[i]['OPERATOR'];
            let returnedResult = parseFloat(data[i]['RESULT']).toFixed(select.value);
            html+= "<tr>";
            if (returnedOperator == "+"){
               html+= '<td style= "color: black;">' + returnedValue + "</td>";
               html+= '<td style= "color: black; text-align: center;">' + returnedOperator + "</td>";
               html+= '<td style= "color: black;">' + returnedResult + "</td>";
               html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(data[i]['ID'],'>') + "Edit" + "</button></td>";
               }else{
                 html+= '<td style= "color: red;">' + returnedValue + "</td>";
                 html+= '<td style= "color: red; text-align: center;">' + returnedOperator + "</td>";
                 html+= '<td style= "color: red;">' + returnedResult + "</td>";
                 html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(data[i]['ID'],'>') + "Edit" + "</button></td>";
                }
                html+= "</tr>";
               }
               tableBody.innerHTML = html;
          console.log(data);
          
      }
      getData2();
     /* openBtn.addEventListener("click", function(){
          window.setTimeout(getData, 5000);
         
      });
      
     /*
        serverReq.onreadystatechange = function() {
            if (serverReq.readyState == 4 && serverReq.status == 200) {
             let responde = JSON.parse(serverReq.responseText);
              console.log(serverReq.responseText);
              let html = "";
               for(let i =0 ; i < responde.length; i++){
                 let returnedValue = responde[i]['value']; 
                 let returnedOperator = responde[i]['operator'];
                 let returnedResult = parseFloat(responde[i]['result'])//.toFixed(select.value);
                 console.log(returnedValue);
                 console.log(returnedOperator);
                 console.log(returnedResult);
                 html+= "<tr>";
                 if (returnedOperator == "+"){
                    html+= '<td style= "color: black;">' + returnedValue + "</td>";
                    html+= '<td style= "color: black; text-align: center;">' + returnedOperator + "</td>";
                    html+= '<td style= "color: black;">' + returnedResult + "</td>";
                    html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(responde[i]['id'],'>') + "Edit" + "</button></td>";
                    }else{
                      html+= '<td style= "color: red;">' + returnedValue + "</td>";
                      html+= '<td style= "color: red; text-align: center;">' + returnedOperator + "</td>";
                      html+= '<td style= "color: red;">' + returnedResult + "</td>";
                      html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(responde[i]['id'],'>') + "Edit" + "</button></td>";
                     }
                     html+= "</tr>";
                    }
                    tableBody.innerHTML = html;
            }
          };*/
          /*function getData(){
            let openReq = new XMLHttpRequest();
            openReq.onreadystatechange = function() {
              if (openReq.readyState == 4 && openReq.status == 200) {
               let responde = JSON.parse(openReq.responseText);
                console.log(openReq.responseText);
                let html = "";
                 for(let i =0 ; i < responde.length; i++){
                   let returnedValue = responde[i]['value']; 
                   let returnedOperator = responde[i]['operator'];
                   let returnedResult = parseFloat(responde[i]['result']).toFixed(select.value);
                   console.log(returnedValue);
                   console.log(returnedOperator);
                   console.log(returnedResult);
                   html+= "<tr>";
                   if (returnedOperator == "+"){
                      html+= '<td style= "color: black;">' + returnedValue + "</td>";
                      html+= '<td style= "color: black; text-align: center;">' + returnedOperator + "</td>";
                      html+= '<td style= "color: black;">' + returnedResult + "</td>";
                      html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: black;" value='.concat(responde[i]['id'],'>') + "Edit" + "</button></td>";
                      }else{
                        html+= '<td style= "color: red;">' + returnedValue + "</td>";
                        html+= '<td style= "color: red; text-align: center;">' + returnedOperator + "</td>";
                        html+= '<td style= "color: red;">' + returnedResult + "</td>";
                        html+= '<td> <button type="button" onclick = "sendId(value)" style=" border: solid 0.1vh; background-color: white;color: red;" value='.concat(responde[i]['id'],'>') + "Edit" + "</button></td>";
                       }
                       html+= "</tr>";
                      }
                      tableBody.innerHTML = html;
              }
            };
            openReq.open("GET", "openSaved.php");
            openReq.send();
        }*/
        //onclick="location.href ='printPage.php'"