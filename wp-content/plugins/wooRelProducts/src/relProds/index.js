
import { registerBlockType } from '@wordpress/blocks';
import { withSelect } from '@wordpress/data';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { decodeEntities } from "@wordpress/html-entities";

registerBlockType('woorelprods/relprods', {
    apiVersion: 2,
    title: 'Related Productcs List',
    attributes: 
    {
        
        selListId:
        {
            type: "number"
        },
        titleBLock:
        {
            type: "string",
            default: "Related Products"
        }
    },
    edit: withSelect((select, props)=>{

        //extraer valores de atributos
        const {attributes: {titleBLock, selListId},setAttributes} = props;
        
        
        const onChangeselListId = newselListId =>{
            setAttributes({selListId: parseInt(newselListId)})
        }
        const onChangetitleBLock = newTitle =>{
            setAttributes({titleBLock: newTitle})
        }
        return {
           
            relatedList:  select("core").getEntityRecords('postType','woorelproducts',{
                per_page:5
            }), 
            idSelected:selListId, 
            products: [],
            onChangeselListId,
            onChangetitleBLock,
            props
        };
    })
    (({relatedList,idSelected,products,onChangeshowQuantity,onChangeselListId,onChangetitleBLock, props}) => {
        

        //Validate relatedProductsList
        if(!relatedList){
            return 'Loading related products...';
        }

        if(relatedList && relatedList.length===0){
            return 'Loading related products...';
        }

        if(idSelected!==0 && typeof relatedList !== 'undefined')
        {
            relatedList.forEach(relProdList=>{
                if(relProdList.id==idSelected){
                    products=relProdList.related_Prods_List
                }
            })
        }        
       

        //extract from props
        const {attributes: {selListId, titleBLock},setAttributes} = props;        
        

        //Generamos los label y values de las relatedList para mostralo en el panel body
        relatedList.forEach(relProdList=>{
            relProdList['label']=relProdList.title_list;
            relProdList['value']=relProdList.id;
        })

        // Arreglo con valores por default
        const opcionDefault = [{value:'0',label:'--Todos--'}];

        const listadorelatedList= [...opcionDefault,...relatedList];
                

        return (
            <>
                <InspectorControls>
                      <PanelBody                              
                            title={'Related Products Lists'}
                            initialOpen={true}
                      >   
                            <div className='components-base-control'>
                                  <div className='components-base-control__field'>
                                        <label className='components-base-control__label'>
                                        Related Products Lists
                                        </label>
                                        <SelectControl 
                                            options={ listadorelatedList }
                                            onChange={onChangeselListId}
                                            value={selListId}
                                        />
                                  </div>
                            </div>                                    
                      </PanelBody>
                      <PanelBody                              
                            title={'Block Title'}
                            initialOpen={false}
                      >   
                            <div className='components-base-control'>
                                  <div className='components-base-control__field'>
                                        <label className='components-base-control__label'>
                                        Block Title
                                        </label>
                                        <TextControl 
                                            onChange={onChangetitleBLock}
                                            value={titleBLock}
                                        />
                                  </div>
                            </div>                                    
                      </PanelBody>
                </InspectorControls>
                <h3 className="titulo-menu">{titleBLock}</h3>
                <div className="container">
                  
                <div class="items">
                {
                products.map(product =>(
                    <div className="entry">
                        <p className="name"><a href={product.permalink}>{product.title}</a></p>
                        <img src={product.thubnail_url}  />
                        <p className="quote">{ decodeEntities(product.currency) } {product.price}</p>
                        <a className='link' href={product.url} >{product.urlText}</a>

                    </div>
                ))}
                </div>   
                </div>          
            </>
        )
    }),   
    save: () =>{
        return null;
    }
})