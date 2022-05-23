import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';


export function ButtonBar({ children }) {
  return (
    <div className="p-3 flex justify-end bg-blue-600">
      { children }
    </div>
  );
}

export function Button({ href, children }) {
  return (
    <Link className="inline-flex items-center px-4 py-2 ml-2 border border-transparent
      rounded-md font-semibold text-xs uppercase tracking-widest transition
      ease-in-out duration-150 text-blue-900 bg-white" href={ href }>{ children }</Link>
  )
}