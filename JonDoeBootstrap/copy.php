<?php foreach($products as $product): ?>
    <div class="card m-5" style="width: 20rem; min-height:30rem;">
  <img class="card-img-top" id="p_<?=$product->id?> src="" alt="<?=$product->item_name?>">
  <div class="card-body">
    <h5 class="card-title text-center"><?=$product->item_name?></h5>
    <p class="card-text text-center"><?=$product->item_description?></p>
    <p><?=$product->item_price?> € </p>
    <a href="#" class="btn btn-outline-warning">BUY</a>
  </div>
</div>
<?php endforeach;?> 

<?php foreach($products as $product): ?>
<div class="d-flex p-2">
  <div class="d-flex flex-row">
    <div class=""></div>
<div class="category">
  <div class="product">                   
    <div class="imgBx">
    <img class="card-img-top" id="p_<?=$product->id?> src="" alt="<?=$product->item_name?>">
    </div>
    <div class="content">
      <h2>
        <?=$product->item_name?>
      </h2>
      <p>
        <?=$product->item_description?>
      </p>
      <p>
        <?=$product->item_price?> € 
      </p>
    </div>   
  </div>
</div>
  </div>
</div>
<?php endforeach;?>