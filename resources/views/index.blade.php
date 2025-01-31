<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-5">
    <div class="container">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Task Manager</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#taskModal">Add Task</button>
            
            <div id="task-list" class="space-y-3"></div>
        </div>
    </div>

    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <h5 class="modal-title">Add New Task</h5>
                <label class="mt-3">Title</label>
                <input type="text" id="taskTitle" class="form-control">
                <label class="mt-2">Description</label>
                <textarea id="taskDescription" class="form-control"></textarea>
                <div class="modal-footer mt-3">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="addTask()">Save Task</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <h5 class="modal-title">Edit Task</h5>
                <label class="mt-3">Title</label>
                <input type="text" id="editTaskTitle" class="form-control">
                <label class="mt-2">Description</label>
                <textarea id="editTaskDescription" class="form-control"></textarea>
                <label class="mt-2">Status</label>
                <select id="editTaskStatus" class="form-control">
                    <option value="0">Pending</option>
                    <option value="1">Completed</option>
                </select>
                <div class="modal-footer mt-3">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="saveEditTask">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <h5 class="modal-title">Confirm Delete</h5>
                <p>Are you sure you want to delete this task?</p>
                <div class="modal-footer mt-3">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let deleteTaskId = null;

        function fetchTasks() {
            axios.get('/api/tasks').then(response => {
                const tasks = response.data.data;
                let taskList = '';
                tasks.forEach(task => {
                    taskList += `
                        <div class="p-4 bg-white rounded-lg shadow flex justify-between items-center">
                            <div>
                                <h5 class="font-bold">${task.title}</h5>
                                <p class="text-gray-600">${task.description || '-'}</p>
                                <span class="text-sm px-2 py-1 rounded-full ${task.is_completed ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white'}">
                                    ${task.is_completed ? 'Completed' : 'Pending'}
                                </span>
                            </div>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="showEditTaskModal(${task.id}, '${task.title}', '${task.description || ''}', ${task.is_completed})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm(${task.id})">Delete</button>
                            </div>
                        </div>`;
                });
                document.getElementById('task-list').innerHTML = taskList;
            });
        }

        function showEditTaskModal(id, title, description, is_completed) {
            document.getElementById('editTaskTitle').value = title;
            document.getElementById('editTaskDescription').value = description;
            document.getElementById('editTaskStatus').value = is_completed ? "1" : "0"; 
            document.getElementById('saveEditTask').onclick = function() {
                updateTask(id);
            };
            let editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
            editModal.show();
        }

        function addTask() {
            const title = document.getElementById('taskTitle').value;
            const description = document.getElementById('taskDescription').value;
            if (!title) {
                alert('Title is required!');
                return;
            }
            axios.post('/api/tasks', { title, description })
                .then(() => {
                    fetchTasks();
                    document.getElementById('taskTitle').value = '';
                    document.getElementById('taskDescription').value = '';
                    bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
                });
        }

        function updateTask(id) {
            const title = document.getElementById('editTaskTitle').value;
            const description = document.getElementById('editTaskDescription').value;
            const is_completed = document.getElementById('editTaskStatus').value === "1";
            axios.put(`/api/tasks/${id}`, { title, description, is_completed })
                .then(() => {
                    fetchTasks();
                    bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
                });
        }

        function showDeleteConfirm(id) {
            deleteTaskId = id;
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            axios.delete(`/api/tasks/${deleteTaskId}`).then(() => {
                fetchTasks();
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
            });
        });

        fetchTasks();
    </script>
</body>
</html>
