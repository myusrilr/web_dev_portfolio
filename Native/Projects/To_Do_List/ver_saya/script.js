// getting all required elements
const inputBox = document.querySelector(".inputField input");
const addBtn = document.querySelector(".inputField button");
const todoList = document.querySelector(".todoList");
const deleteAllBtn = document.querySelector(".footer button");

// onkeyup event
inputBox.onkeyup = () => {//if user releases the key
    let userEnteredValue = inputBox.value;//getting user entered value
    if (userEnteredValue.trim() != 0) {//if user values aren't only spaces
        addBtn.classList.add("active");//active the add button
    } else {
        addBtn.classList.remove("active");//unactive the add button
    }
}

showTasks();//calling showTasks function

//if user clicks on the add button
addBtn.onclick = () => {
    let userEnteredValue = inputBox.value;//getting user entered value
    let getLocalStorageData = localStorage.getItem("New Todo");//getting localstorage data
    if (getLocalStorageData == null) {//if localstorage is null
        listArray = [];//creating blank array
    } else {
        listArray = JSON.parse(getLocalStorageData);//transforming json string into a js object

    }
    listArray.push(userEnteredValue);//pushing or adding user data
    localStorage.setItem("New Todo", JSON.stringify(listArray));//transforming js object into a json string
    showTasks();//calling showTasks function
    addBtn.classList.remove("active");//unactive the add button
}
// function to add task List inside ul
function showTasks() {
    let getLocalStorageData = localStorage.getItem("New Todo");//getting localstorage data
    if (getLocalStorageData == null) {//if localstorage is null
        listArray = [];//creating blank array
    } else {
        listArray = JSON.parse(getLocalStorageData);//transforming json string into a js object
    }
    const pendingTasksNumb = document.querySelector(".pendingTasks");
    pendingTasksNumb.textContent = listArray.length;//passing the length value in pendingTasksNumb
    if (listArray.length > 0) {//if array lenght is greater than 0
        deleteAllBtn.classList.add("active");//active the  clearAllButton
    }else {
        deleteAllBtn.classList.remove("active");//unactive the clearAllButton
    }
    let newLiTag = "";
    listArray.forEach((element, index) => {
        newLiTag += `<li> ${element} <span class="icon" onclick= "deleteTask(${index})"><i class="fas fa-trash"></i></span></li>`;
    });
    todoList.innerHTML = newLiTag;//adding new li tag inside ul tag
    inputBox.value = "";//once task added leave the input field blank

}

// delete task function
function deleteTask(index) {
    let getLocalStorageData = localStorage.getItem("New Todo");//getting localstorage data
    listArray = JSON.parse(getLocalStorageData);//transforming json string into a js object
    listArray.splice(index, 1);//delete or remove the particular indexed li
    // after remove the li again update the localstorage
    localStorage.setItem("New Todo", JSON.stringify(listArray));//transforming js object into a json string
    showTasks();//calling showTasks function
}

// delete all task function
deleteAllBtn.onclick = () => {
    let getLocalStorageData = localStorage.getItem("New Todo");//getting localstorage data
    if (getLocalStorageData == null) {//if localstorage is null
        listArray = [];//creating blank array
    } else {
        listArray = JSON.parse(getLocalStorageData);//transforming json string into a js object
        listArray = [];//empty an array
    }
    localStorage.setItem("New Todo", JSON.stringify(listArray));//transforming js object into a json string
    showTasks();//calling showTasks function
}