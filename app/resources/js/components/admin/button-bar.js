import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';
import { Stripe } from '@/layouts/admin/frame';

export function ButtonBar({ children }) {
  return (
    <Stripe>
      <div className="flex justify-end">
        { children }
      </div>
    </Stripe>
  );
}

export function Button({ href, children }) {
  return (
    <Link className="inline-flex items-center px-4 py-2 ml-2 border border-transparent
      rounded-md font-semibold text-xs uppercase tracking-widest transition
      ease-in-out duration-150 text-blue-900 bg-white" href={ href }>{ children }</Link>
  )
}
