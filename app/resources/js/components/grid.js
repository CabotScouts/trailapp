import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export function Grid({ children }) {
  return (
    <div className="grid grid-cols-2 md:grid-cols-4 gap-3 p-3">
      {children}
    </div>
  )
}

export function GridItem({ href, className, children }) {
  return (
    <Link href={href}>
      <div className={`p-4 rounded-xl ${className}`}>
        <div className="mt-6 font-serif text-2xl text-neutral-100">{children}</div>
      </div>
    </Link>
  )
}
