import React, { useState } from 'react'

const ClientForm = ({onClickCallback, addNewClient}) => {
  const [firstname,setFirstname] = useState('');
  const [lastname,setLastname] = useState('');
  const [email,setEmail] = useState('');
  const [address,setAddress] = useState('');
  const [tel,setTel] = useState('');

  const [load,setLoad] = useState(false);

  // const BaseUrl = "https://logiciel.solumat-sarl.com";
  const BaseUrl = "http://localhost:8000";

  const handleSubmitForm = (e) => {
    e.preventDefault()

    setLoad(true);

    const data = {
      lastname,
      firstname,
      email,
      tel,
      address
    };

    axios.post(`${BaseUrl}/api/clients`,data).then(res => {
      
      if(res.data.success){
        addNewClient(true);
        setLoad(false);
      }

    }).catch(err => {
      setLoad(false);
      setSessionMsgError(err.response.data.message);
    });
  }

  return (
    <form onSubmit={handleSubmitForm} className='text-gray-500'>
      <h1 className='text-2xl mb-5 font-bold border-b'>Creation d'un nouveau client</h1>
      <div className="flex justify-between mb-4">
        <div className='flex w-1/2 mr-2 flex-col justify-start items-start'>
          <label className='font-bold mb-1'>Nom </label>
          <input required type="text" value={lastname} onChange={e => setLastname(e.target.value)} placeholder='Entrer le nom du client' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
        </div>
        <div className='flex w-1/2 ml-2 flex-col justify-start items-start'>
          <label className='font-bold mb-1'>Prenom </label>
          <input required type="text" value={firstname} onChange={e => setFirstname(e.target.value)} placeholder='Entrer le prénom du client' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
        </div>
      </div>
      <div className="flex justify-between mb-5">
        <div className='flex w-1/2 mr-2 flex-col justify-start items-start'>
          <span><label className='font-bold mb-2 inline-block'>Email </label> <span className="text-gray-400 text-sm italic font-normal"> (Facultatif)</span></span>
          <input type="email" value={email} onChange={e => setEmail(e.target.value)}  placeholder='Email du client' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
        </div>
        <div className='flex w-1/2 ml-2 flex-col justify-start items-start'>
          <span><label className='font-bold mb-2 inline-block'>Adresse </label> <label className='font-bold mb-1'> </label> <span className="text-gray-400 text-sm italic font-normal"> (Facultatif)</span></span>
          <input type="address" value={address} onChange={e => setAddress(e.target.value)}  placeholder='Adresse du client' className='px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none' />
        </div>
      </div>
      <div className="text-center mt-6">
        <button onClick={() => onClickCallback(false)}  className="px-6 mr-3 rounded-md font-bold py-2 cursor-pointer bg-secondary text-white">Retour</button>
        <button type='submit' className="px-6 cursor-pointer rounded-md font-bold py-2 bg-primary text-white">{load ? 'Chargement ...':'Ajouter le client'}</button>
      </div>
    </form>
  )
}

export default ClientForm