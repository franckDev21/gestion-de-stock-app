import axios from "axios";
import React, {useEffect, useState} from "react";
import ClientForm from "../components/ClientForm";
import { format_number } from "../utils/utils";

const Commande = ({ user_id }) => {

  const [products,setProducts] = useState([]);
  const [clients,setClients] = useState([]);
  const [client,setClient] = useState('');
  const [desc,setDesc] = useState('');
  const [carts,setCarts] = useState([]);
  const [tabProductSearch,setTabProductSearch] = useState([]);
  const [filter,setFilter] = useState('');
  const [showClientForm,setShowClientForm] = useState(false);
  const [addNewClientState,setAddNewClientState] = useState(false);
  const [success,setSuccess] = useState(false);
  const [commadeId,setCommadeId] = useState('');

  const [load,setLoad] = useState(false);

  useEffect(() => {
    axios.get('https://stock.solumat-sarl.com/api/products').then(res => {
      setProducts(res.data);
    });
    axios.get('https://stock.solumat-sarl.com/api/clients').then(res => {
      setClients(res.data);
    });
  },[]);

  useEffect(() => {
    axios.get('https://stock.solumat-sarl.com/api/clients').then(res => {
      setClients(res.data);
    }).catch(err => console.log(err));
  },[addNewClientState]);

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
      let nbreUnites;

      if((product.unite_mesure === 'KG' || product.unite_mesure === 'G') && !product.nbre_par_carton){
        if(product.vendu_par_piece){
          nbreUnites = product.qte_en_stock;
        }else{
          nbreUnites =  (product.qte_en_stock * product.poids) + product.reste_unites;
        }
      } else if((product.unite_mesure !== 'KG' || product.unite_mesure !== 'G') && !product.nbre_par_carton){
        nbreUnites =  (product.qte_en_stock * product.qte_en_littre) + product.reste_unites;
      } else{
        nbreUnites =  (product.qte_en_stock * product.nbre_par_carton) + product.reste_unites;
      }

      newProduct = {
        ...product,
        qte : 1,
        max : nbreUnites
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
    let prix = 0
    carts.forEach(product => {
      som += (parseInt(product.qte,10) || 0)
      prix += ((parseInt(product.qte,10) || 0) * product.prix_unitaire)
    })
    return {
      som : ((som > 0) && client !== ''),
      prix : prix,
      qte : som
    }
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

  const commander = (e) => {

    e.preventDefault();

    setLoad(true);

    let data = {
      user_id,
      client,
      carts,
      desc,
      total_qte: isValid().qte,
      totalCommande: isValid().prix
    }

    axios
      .post('https://stock.solumat-sarl.com/api/commandes',data).then(res => {

      console.log(res.data);
        if(res.data.success){
          setCommadeId(res.data.success)
          setSuccess(true);
        }

        setLoad(false);
      })
      .catch(err => {
        console.log(err);
        setLoad(false);
      });

    console.log(data);
  }

  useEffect(() => {
    search()
  },[filter])

  return (
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
      <div className={`bg-white min-h-[450px] px-6 py-5 rounded-md mt-5 flex ${success ? ' justify-center flex-col items-center ':'justify-between items-start'}`}>
        {success ? (
          <>
            <i className="fa-solid fa-check text-primary text-9xl inline-block mb-4"></i>
            <h1 className="text-3xl px-10 w-1/2 text-center font-bold text-gray-500">La commande a été enregistrer <br /> avec success</h1>
            <p className=" text-center my-2 w-1/2 text-sm text-gray-500">un Email a été envoyer a <span className="text-primary">Mme Nicole </span>pour facture de sa commande</p>
            <div className="flex w-full items-center justify-center mt-6">
              <button onClick={() => {
                window.location = `https://stock.solumat-sarl.com/commandes`
              }} className="px-5 py-3 w-[22%] uppercase bg-opacity-80 transition hover:bg-opacity-100 active:scale-95 bg-secondary rounded-md text-white ml-4">liste des commande</button>
              <button onClick={() => {
                window.location = `https://stock.solumat-sarl.com/commandes/${commadeId}`
              }} className="px-5 py-3 w-[22%] uppercase bg-opacity-80 transition hover:bg-opacity-100 active:scale-95 bg-primary rounded-md text-white ml-4">voir la commande créée</button>
            </div>
          </>
        ):(
          <>
            <div className="w-[50%] mr-2">
              {!showClientForm &&
                <div className="my-2 flex flex-col">
                  <h3 className="text-lg font-semibold text-gray-500 mb-3">
                    Client
                  </h3>
                  <div className="mt-1 flex justify-between items-center w-full">
                    <select value={client} onChange={(e) => setClient(e.target.value)} className="px-6 w-[70%] py-2 border-2 bg-gray-100 rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none">
                      <option value="">
                        -- selectionnez un client --
                      </option>
                      {clients.map(client => (
                        <option value={client.id} key={client.id}>{client.firstname} {client.lastname}</option>
                      ))}
                    </select>
                    <button onClick={() => setShowClientForm(true)} className="px-4 py-2 ml-2 w-[30%] bg-primary bg-opacity-80 hover:bg-opacity-100 rounded-md text-white">
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
                        value={desc}
                        onChange={(e) => setDesc(e.target.value)}
                        className="px-6 w-full py-2 placeholder:italic bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none"
                        id=""
                        cols="30"
                        rows="10"
                        placeholder="Entrez la description de la commande ici..."
                      ></textarea>
                    </div>
                  </div>
                </div>}
              {showClientForm && <>
                <ClientForm addNewClient={(value) => {
                setAddNewClientState(value);
                setShowClientForm(false);
                }} onClickCallback={(value) => setShowClientForm(value)} />
              </>}
            </div>
            <form onSubmit={commander} className="w-[50%] ml-2">
              <div className="relative z-50">
                <input type="text" value={filter} onChange={(e) => setFilter(e.target.value)} placeholder='Réchercher un produit ici' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
                <i className="fa-solid fa-magnifying-glass absolute top-1/2 -translate-y-1/2 right-4 text-gray-500"></i>

                <div className="bg-gray-300 absolute w-full flex-col flex justify-start items-start top-full left-0 ring-0 rounded-b-md">
                  {tabProductSearch.map(product => (
                    <div style={{ zIndex: 1000 }} onClick={() => addToCart(product)} key={product.id} className="w-full z-50 flex justify-start items-start mb-2 p-1 hover:bg-gray-200 transition cursor-pointer">
                      <div className="w-10 relative h-10 overflow-hidden">
                        <img src={`${product.image ? `/storage/${product.image}` :'/static/img/product.png'}`} className=" absolute z-0 h-auto w-full object-cover" />
                      </div>
                      <div className="ml-2 -translate-y-1">
                        <h2 className="font-semibold text-gray-600">{product.nom}</h2>
                        <h2 className="font-semibold text-sm text-primary">prix unitaire : {format_number(product.prix_unitaire)} 
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
                          <h2 className="font-semibold text-sm text-primary">Prix unitaire : {format_number(product.prix_unitaire)}  </h2> 
                          <div>
                            <input min={0} max={product.max} value={findProduct(product.id).qte || 0} onChange={(e) => setQte(product.id,e.target.value)}  type="number" className="mt-1 appearance-none px-1 text-center font-bold w-20 py-1 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none" />
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
                <div className="my-4 border-y flex justify-end items-center">
                  <span className="text-3xl text-gray-500 font-bold py-3 inline-block">
                    <span className="text-secondary pr-2">Total : </span>
                    <span>{format_number(isValid().prix)}</span>
                  </span>
                </div>
                <div className="py-3">
                  <button className={`bg-primary ${!isValid().som && 'disabled'} border-2 border-primary transition text-white px-6 py-2 w-full rounded-md`}>{load ? "Enregistrement en cours ...":"Commander"}</button>
                </div>
              </div>
            </form>
          </>
        )}
      </div>
    </div>
  );
};

export default Commande;
