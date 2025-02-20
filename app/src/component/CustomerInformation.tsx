import { useEffect, useState } from "react";
import axiosService from "../service/webservice";

function CustomerInformation(data : any) {
    const [customerData, setCustomerData] = useState([]);
    
	const fetchCustomer = async (id:number = 1) => {
		axiosService.get(`customers/${id}`)
		.then((response) => {
			if (response.status === 200) {
				setCustomerData(response.data);
			}
		});
	}

    useEffect(() => {
        fetchCustomer(data.id);
    }, []);

    return (
        <div className="p-4 px-10">
            <h1 className="text-xl font-bold">Customer Information</h1>

            {
                (customerData && customerData.id) ? (
                    <>
                        <div className="p-2">
                            <h2>First Name: <b>{customerData.first_name}</b></h2>
                            <h2>Last Name: <b>{customerData.last_name}</b></h2>
                            <h2>Email: <b>{customerData.email}</b></h2>
                            <h2>Gender: <b>{customerData.gender}</b></h2>
                        </div>

                        <div className="mt-4">
                            <h1 className="text-lg font-bold">IP Address:</h1>
                            <ul className="pl-2">
                                {customerData.ip_addresses.map((ip: any) => (
                                    <li>{ip.ip_address}</li>
                                ))}
                            </ul>
                        </div>

                        <div className="mt-4">
                            <h1 className="text-lg font-bold">Companies:</h1>
                            <table className="w-full border">
                                <thead>
                                    <tr>
                                        <th className="p-2 border">Name</th>
                                        <th className="p-2 border">City</th>
                                        <th className="p-2 border">Title</th>
                                        <th className="p-2 border">Website</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {customerData.companies.map((c: any) => (
                                        <tr>
                                            <td className="p-2 border">{c.company}</td>
                                            <td className="p-2 border">{c.city}</td>
                                            <td className="p-2 border">{c.title}</td>
                                            <td className="p-2 border"><a href={c.website} target="_blank">{c.website}</a></td>
                                        </tr>
                                    ))}
                                </tbody>

                            </table>
                        </div>
                    </>
                ) :
                (
                    <h2>Loading...</h2>
                )
            }

            {/* <pre>{JSON.stringify(customerData, null, 2)}</pre> */}
        </div>
    );
}

export default CustomerInformation;