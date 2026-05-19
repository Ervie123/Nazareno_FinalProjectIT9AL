<?php if($paginator->hasPages()): ?>
    <div style="display:flex; justify-content:center; margin-top:25px;">
        <div style="display:flex; gap:10px;">

            
            <?php if($paginator->onFirstPage()): ?>
                <span class="page-btn disabled">←</span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="page-btn">←</a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php if(is_string($element)): ?>
                    <span class="page-btn dots"><?php echo e($element); ?></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span class="page-btn active"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="page-btn"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="page-btn">→</a>
            <?php else: ?>
                <span class="page-btn disabled">→</span>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>