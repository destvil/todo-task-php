import {TaskList} from "./taskList.js";

let taskList = new TaskList();
taskList.initialize();

let headerToastContainer = document.querySelector('.header-toasts');
let headerToastList = headerToastContainer.querySelectorAll('.toast');
Array.from(headerToastList).forEach(toastNode  => {
    let toast = new bootstrap.Toast(toastNode);
    toast.show();
})