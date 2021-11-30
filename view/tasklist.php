<!-- Inherit from "head" --!>
<?php $this->loadView('head', ['title' => $title]); ?>

<h1> <?= $title; ?> </h1>
<a href="/new-task"><button>Add a new task</button></a>

<hr>

<?php if (empty($taskList)):  ?>
  <span> Your task list is empty. </span>
<?php else:  ?>
  <?php foreach($taskList as $tasks): ?>
      <h5>
          <?= $tasks[0]->getSchedule()->format('D, d M'); ?>
      </h5>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Deadline</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tasks as $task): ?>
            <tr> 
                <th><?= $task->getName(); ?></th>
                <th><?= $task->getDeadline()->format('d/m/Y'); ?></th>
                <th>
                    <a href="/edit?id=<?= $task->getId(); ?>">
                        <button>Edit</button>
                    </a>
                    <a href="/delete?id=<?= $task->getId(); ?>">
                        <button>Delete</button>
                    </a>
                </th>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
  <?php endforeach; ?>
<?php endif; ?>
