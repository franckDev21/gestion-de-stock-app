import axios from "axios";
import React, {useEffect, useState} from "react";

const Commande = ({ }) => {

  const [products,setProducts] = useState([]);
  const [carts,setCarts] = useState([]);
  const [tabProductSearch,setTabProductSearch] = useState([]);
  const [filter,setFilter] = useState('');

  useEffect(() => {
    axios.get('/api/products').then(res => {
      setProducts(res.data);
    });
  },[]);

  const search = () => {
    if(filter !== ''){
      let newTab = products.filter(product => (product.nom.includes(filter) || product.type_approvionement.includes(filter) || product.prix_unitaire.toString().includes(filter)))
      let tab = []
      if(newTab.length > 0){
        newTab.forEach((product,i) => {
          if(i <= 5){
            tab.push(product)
          }
        })
      }
      setTabProductSearch(tab)
    }else{
      setTabProductSearch([])
    }
  }

  const addToCart = (product) => {
    if(!product.is_stock) return
    let exist = carts.find(p => p.id === product.id) ? true : false
    let newProduct;
    if(!exist){
      newProduct = {
        ...product,
        qte : 1
      }
      setCarts(state => [...state,newProduct])
    }else{
      let copieCarts = carts;
      let produitFind = copieCarts.find(p => p.id === product.id);
      produitFind.qte = (parseInt(produitFind.qte,10) || 0) + 1
      copieCarts = carts.filter(p => p.id !== product.id)
      copieCarts = [...copieCarts,produitFind]
      setCarts(copieCarts)
    }
    setFilter('')
  }

  const isValid = () => {
    let som = 0
    carts.forEach(product => {
      som += (parseInt(product.qte,10) || 0)
    })
    return som > 0
  }

  const setQte = (id,value) => {
    let copieCarts = carts;
    let produitFind = copieCarts.find(product => product.id === id);
    produitFind.qte = parseInt(value,10) || 0
    copieCarts = carts.filter(product => product.id !== id)
    copieCarts = [...copieCarts,produitFind]
    setCarts(copieCarts)
  }

  const deleteProduct = (id) => {
    let cartFiltereds = carts.filter(product => product.id !== id)
    setCarts(cartFiltereds)
  }

  const findProduct = (id) => {
    return carts.find(product => product.id === id)
  }

  const commander = () => {
    console.log(carts);
  }

  useEffect(() => {
    search()
  },[filter])

  return (
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
      <div className="bg-white min-h-[450px] px-6 py-5 rounded-md mt-5 flex justify-between items-start">
        <div className="w-[50%] mr-2">
          <div className="my-2 flex flex-col">
            <h3 className="text-lg font-semibold text-gray-500 mb-3">
              Client
            </h3>
            <div className="mt-1 flex justify-between items-center w-full">
              <select className="px-6 w-[70%] py-2 border-2 bg-gray-100 rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none">
                <option value="">
                  -- selectionnez un client --
                </option>
              </select>
              <button className="px-4 py-2 ml-2 w-[30%] bg-primary bg-opacity-80 hover:bg-opacity-100 rounded-md text-white">
                Nouveau client
              </button>
            </div>

            <div className="my-2 flex flex-col mt-4">
              <h3 className="text-lg font-semibold text-gray-500 mb-3">
                Description de la commande{" "}
                <span className="text-gray-400 text-sm italic font-normal">
                  (Facultatif)
                </span>
              </h3>
              <div className="mt-1 flex justify-between items-center">
                <textarea
                  name=""
                  className="px-6 w-full py-2 placeholder:italic bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none"
                  id=""
                  cols="30"
                  rows="4"
                  placeholder="Entrez la description de la commande ici..."
                ></textarea>
              </div>
            </div>
          </div>
        </div>
        <div className="w-[50%] ml-2">
          <div className="relative z-50">
            <input type="text" value={filter} onChange={(e) => setFilter(e.target.value)} placeholder='Réchercher un produit ici' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
            <i className="fa-solid fa-magnifying-glass absolute top-1/2 -translate-y-1/2 right-4 text-gray-500"></i>

            <div className="bg-gray-300 absolute w-full flex-col flex justify-start items-start top-full left-0 ring-0 rounded-b-md">
              {tabProductSearch.map(product => (
                <div style={{ zIndex: 1000 }} onClick={() => addToCart(product)} key={product.id} className="w-full z-50 flex justify-start items-start mb-2 p-1 hover:bg-gray-200 transition cursor-pointer">
                  <div className="w-10 h-10 bg-slate-50"></div>
                  <div className="ml-2 -translate-y-1">
                    <h2 className="font-semibold text-gray-600">{product.nom}</h2>
                    <h2 className="font-semibold text-sm text-primary">prix unitaire : {product.prix_unitaire} FCFA 
                      {product.is_stock ?  <>
                        <span className="px-2 font-normal rounded-lg mx-2 py-1 text-xs bg-green-100 text-green-500">En stock</span> | {product.qte_en_stock} {product.type_approvionement}(s) {!product.vendu_par_piece && `et ${product.reste_unites || 0} unité(s)` }
                      </>: <span className="px-2 font-normal rounded-lg mx-2 py-1 text-xs bg-red-100 text-red-500">stock vide</span>}
                     
                    </h2> 
                  </div>
                </div>
              ))}

            </div>
          </div>
          
          <div className="mt-3 z-0">
            {carts.length > 0 ? (
              <>
                {carts.map((product,i) => (
                  <div key={`${product.id}-${i}`} className="w-full flex justify-start items-start mb-2 p-1 relative z-10 ">
                    <i onClick={() => deleteProduct(product.id)} className="fa-solid fa-times absolute right-2 cursor-pointer hover:bg-red-100 p-2 top-2 text-red-500 z-50"></i>
                    <div className="w-24 h-24 relative overflow-hidden z-10">
                      <img src={`${product.image ? `/storage/${product.image}` :'/static/img/product.png'}`} className=" z-0 h-auto w-full object-cover" />
                    </div>

                    <div className="ml-2 -translate-y-1">
                      <h2 className="font-semibold text-gray-600">{product.nom}</h2>
                      <h2 className="font-semibold text-sm text-primary">Prix unitaire : {product.prix_unitaire} FCFA  </h2> 
                      <div>
                        <input value={findProduct(product.id).qte || 0} onChange={(e) => setQte(product.id,e.target.value)}  type="number" className="mt-1 appearance-none px-1 text-center font-bold w-20 py-1 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none" />
                      </div>
                    </div>
                  </div>
                ))}
              </>
            ):(
              <div className="min-h-[200px] text-center text-gray-500 text-2xl bg-slate-100 rounded-md flex flex-col justify-center items-center">
                <i className="fa-solid fa-cart-shopping text-3xl text-primary"></i>
                <span className="mb-2 mt-1">Aucun produit séléctionner </span>
                <span className="text-base px-5">veillez réchercher le(s) et cliquez dessus pour les ajoutes dans la commande</span>
              </div>
            )}

            <div className="py-3">
              <button onClick={() => commander()} className={`bg-primary ${!isValid() && 'disabled'} border-2 border-primary transition text-white px-6 py-2 w-full rounded-md`}>Commander</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Commande;
