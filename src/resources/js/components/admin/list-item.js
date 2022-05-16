import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function ListItem({ children }) {
  return (
    <div className="p-5 flex items-center border border-b-blue-200">
      { children }
    </div>
  )
}
