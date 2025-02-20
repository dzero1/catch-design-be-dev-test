import { useState, useEffect } from 'react'
import DataTable from 'react-data-table-component';
import axiosService from '../service/webservice';
import CustomerInformation from '../component/CustomerInformation';

function CustomersPage() {
	const columns = [
		{
			name: 'ID',
			selector: (row:any) => row.id,
		},
		{
			name: 'First Name',
			selector: (row:any) => row.first_name,
		},
		{
			name: 'Last Name',
			selector: (row:any) => row.last_name,
		},
		{
			name: 'Email',
			selector: (row:any) => row.email,
		},
		{
			name: 'Gender',
			selector: (row:any) => row.gender,
		},
	];

	const [loading, setLoading] = useState(false);
	const [data, setData] = useState([]);
	const [perPage, setPerPage] = useState(10);
	const [totalRows, setTotalRows] = useState(0);

	const fetchCustomers = async (page:number = 1) => {
		setLoading(true);
		axiosService.get(`customers?page=${page}&per_page=${perPage}`)
		.then((response) => {
			if (response.status === 200) {
				setData(response.data.data);
				setTotalRows(response.data.total);
			}
			setLoading(false);
		});
	}

	const handlePageChange = (page: number) => {
		fetchCustomers(page);
	};

	const handlePerRowsChange = async (newPerPage:number, page:number) => {
		setPerPage(newPerPage);
		fetchCustomers(page);
	};

	useEffect(() => {
		fetchCustomers(1);
	}, []);

	return (
		<div className='p-20'>
		<DataTable
			columns={columns}
			data={data}
			progressPending={loading}
			pagination
			paginationServer
			paginationTotalRows={totalRows}
			onChangeRowsPerPage={handlePerRowsChange}
			onChangePage={handlePageChange}
			expandableRows
			expandableRowsComponent={CustomerInformation} 
		/>
		</div>
	)
}

export default CustomersPage
