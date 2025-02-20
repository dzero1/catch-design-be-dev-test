import { use, useState, useEffect } from 'react'
import {useNavigate} from 'react-router-dom'
import { AxiosResponse } from "axios";

import axiosService from '../service/webservice';

function LoginPage() {
	
	const navigate = useNavigate()
	const [email, setEmail] = useState('test@example.com');
	const [password, setPassword] = useState('Password@321');

	function login(){
		axiosService.post('login', {
			email: email,
			password: password 
		}).then((response:AxiosResponse) => {

			if (response.status === 200) {
				localStorage.setItem("token", response.data.access_token);

				navigate('/customers');
			}
		})
	}

	return (
		<div className='flex justify-center items-center h-screen'>
			<div className='w-1/3 h-1/3 p-4 bg-gray-100 border border-gray-200 rounded-lg flex flex-col justify-center'>
				<h1 className="text-2xl font-bold">Login</h1>

				<div className="mt-4">
					<label className="block text-sm font-medium text-gray-700">Email</label>
					<input type="email" value={email} onChange={e => setEmail(e.target.value)} className="mt-1 bg-white block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
				</div>

				<div className="mt-4">
					<label className="block text-sm font-medium text-gray-700">Password</label>
					<input type="password" value={password} onChange={e => setPassword(e.target.value)} className="mt-1 bg-white block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
				</div>

				<div className="mt-4">
					<button className="w-full rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 active:bg-indigo-800 cursor-pointer" onClick={() => login()}>Login</button>
				</div>
			</div>
		</div>
	)
}

export default LoginPage
