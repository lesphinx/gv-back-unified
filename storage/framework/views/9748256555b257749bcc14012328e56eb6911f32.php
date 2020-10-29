<?php $__env->startSection('title'); ?>
Utilisateur
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="panel panel-default">
        <div class="panel-heading">Utilisateurs</div>

        <div class="panel-body">

<?php if(Sentinel::getUser()->hasAccess(['user.create'])): ?>
<a href="<?php echo e(route('user.create')); ?>" class="btn btn-success">Nouveau Utilisateur</a>
<?php endif; ?>
<table class="table table-bordered table-striped table-hover" id="tblUsers">
    <thead>
        <tr>

            <th>Tout selectionner <input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
            <th>Nom</th>
            <th>Prénon</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Date Création</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(Form::checkbox('sel', $user->id, null, ['class' => ''])); ?></td>
                <td><a href="<?php echo e(route('user.show', $user->id)); ?>"><?php echo e($user->first_name); ?></a></td>
                <td><a href="<?php echo e(route('user.show', $user->id)); ?>"><?php echo e($user->last_name); ?></a></td>
                <td><?php echo e($user->email); ?></td>
                
                <td> <a href="<?php echo e(route('user.index',['type='.$user->roles()->first()->name])); ?>"><?php echo e(empty($user->roles()->first())?"":$user->roles()->first()->name); ?></a>  </td>
                <td><?php echo e($user->created_at); ?></td>
                <td>
                    <?php if(Sentinel::getUser()->hasAccess(['user.show'])): ?>
                    <a href="<?php echo e(route('user.show', $user->id)); ?>" class="btn btn-success btn-xs">Détail</a>
                    <?php endif; ?>
                    <?php if(Sentinel::getUser()->hasAccess(['user.edit'])): ?>
                    <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="btn btn-success btn-xs">Editer</a>
                    <?php endif; ?>
                    <?php if(Sentinel::getUser()->hasAccess(['user.permissions'])): ?>
                    <a href="<?php echo e(route('user.permissions', $user->id)); ?>" class="btn btn-warning btn-xs">Permissions</a>
                    <?php endif; ?>
                    <?php if(Sentinel::getUser()->hasAccess(['user.destroy'])): ?>
                    <?php echo Form::open(['method'=>'DELETE', 'route' => ['user.destroy', $user->id], 'style' => 'display:inline']); ?>

                    <?php echo Form::submit('Supprimer', ['class' => 'btn btn-danger btn-xs','id'=>'delete-confirm']); ?>

                    <?php echo Form::close(); ?>

                    <?php endif; ?>
                    
                    <?php if(sizeof($user->activations) == 0): ?>
                    <?php if(Sentinel::getUser()->hasAccess(['user.activate'])): ?>
                    <a href="<?php echo e(route('user.activate', $user->id)); ?>" class="btn btn-primary btn-xs">Activer</a>
                    <?php endif; ?>
                    <?php else: ?>
                    <?php if(Sentinel::getUser()->hasAccess(['user.deactivate'])): ?>
                     <a href="<?php echo e(route('user.deactivate', $user->id)); ?>" class="btn btn-warning btn-xs">Désactiver</a>
                     <?php endif; ?>
                    <?php endif; ?>
                    
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php if(Sentinel::getUser()->hasAccess(['user.destroy'])): ?>
<button id="delete_all" class='btn btn-danger btn-xs'>Supprimer la selection</button>
<?php endif; ?>
<?php if(Sentinel::getUser()->hasAccess(['user.activate'])): ?>
<button id="activate_all" class='btn btn-primary btn-xs'>Tout activer</button>
<?php endif; ?>
<?php if(Sentinel::getUser()->hasAccess(['user.deactivate'])): ?>
<button id="deactivate_all" class='btn btn-warning btn-xs'>Tout désactiver</button>
<?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        table = $('#tblUsers').DataTable({
            'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
            }],
          'order': [1, 'asc']
            });
    });
      // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
  $("input#delete-confirm").on("click", function(){
        return confirm("êtes vous sûr de supprimer?");
    });
  // start Delete All function
  $("#delete_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sûr de supprimer?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "<?php echo e(action('UserController@ajax_all')); ?>",
                    data: {all_id:value,action:'delete'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectioner d'abord");}
        }
        return false;
   });
  //End Delete All Function
  //Start Deactivate all Function
    $("#deactivate_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sûr de désactiver ?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "<?php echo e(action('UserController@ajax_all')); ?>",
                    data: {all_id:value,action:'deactivate'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectionner d'abord");}
        }
        return false;
    });
    //End Deactivate Function
      //Start Activate all Function
    $("#activate_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sur d'activer cet utilisateur ?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "<?php echo e(action('UserController@ajax_all')); ?>",
                    data: {all_id:value,action:'activate'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectionner d'abord");}
        }
        return false;
    });
    //End Activate Function



   
   function get_Selected_id() {
    var searchIDs = $("input[name=sel]:checked").map(function(){
      return $(this).val();
    }).get();
    return searchIDs;
   }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>