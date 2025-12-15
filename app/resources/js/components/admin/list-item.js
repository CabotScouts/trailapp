import React from 'react';
import { Link } from '@inertiajs/react';

export default function ListItem({ children }) {
  return (
    <div className="p-5 flex items-center border-b border-b-slate-200">
      {children}
    </div>
  )
}
