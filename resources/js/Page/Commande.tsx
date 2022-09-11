import React from "react";

type CommandeType = {};

const Commande: React.FC<CommandeType> = ({}) => {
    return (
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
            <div className="bg-white px-6 py-5 rounded-md mt-5 flex justify-between items-start">
                <div className="w-[60%] mr-2">
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
                            <button className="px-4 py-2 ml-2 w-[30%] bg-primary rounded-md text-white">
                                Nouveau client
                            </button>
                        </div>

                        <div className="my-2 flex flex-col mt-4">
                            <h3 className="text-lg font-semibold text-gray-500 mb-3">
                                Description de la commande <span className='text-gray-400 text-sm italic font-normal'>(Facultatif)</span>
                            </h3>
                            <div className="mt-1 flex justify-between items-center">
                                <textarea
                                    name=""
                                    className="px-6 w-full py-2 bg-gray-100 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-600 outline-none border-none"
                                    id=""
                                    cols="30"
                                    rows="4"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="w-[40%] ml-2">

                </div>
            </div>
        </div>
    );
};

export default Commande;
