<table class="form-table">
        <tr>
            <th class="row-title" colspan="2"></th>
            <h2>Select the products you want to show in this list of related Products:</h2>
        </tr>
        <tr>
            <th class="row-title"><label for="">Select from the list</label></th>
            <td>
                <?php
                    $args = array(
                        'post_type'=>'product',
                        'posts_per_page'=>-1,
                    );
                    $productos=get_posts($args);

                    if($productos):
                ?>
                    <?php $seleccionadas=maybe_unserialize(get_post_meta( $post->ID, 'relatedProds', true ));  ?>
                    <select data-placeholder="Choose the products you want to show..." class="chosen_relprods" name="relatedProds[]" multiple tabindex="1">
                        <option value=""></option>
                        <?php foreach($productos as $producto): ?>
                            <?php if($seleccionadas){ ?>
                                <option <?php echo (in_array($producto->ID,$seleccionadas))?'selected':''; ?> value="<?php echo $producto->ID; ?>"><?php echo $producto->post_title; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $producto->ID; ?>"><?php echo $producto->post_title; ?></option>
                            <?php } ?>
                            
                        <?php endforeach; ?>         
                    </select>
                <?php
                    else:
                        echo "You should create products first";
                    endif;                    
                ?>

            </td>
        </tr>
    </table>