import { createRoot } from 'react-dom/client'
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import './index.css'
import LoginPage from './pages/Login.tsx';
import CustomersPage from './pages/Customers.tsx';

createRoot(document.getElementById('root')!).render(
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<LoginPage />} />

        <Route path="customers" element={<CustomersPage />}>
          <Route index element={<CustomersPage />} />
          {/* <Route path="project/:id" element={<Project />} /> */}
        </Route>

      </Routes>
    </BrowserRouter>
)
