import React from 'react';

export default function ModalHeader({ data }) {
  return (
    <div className="p-10 text-neutral-50">
      <div className="pt-5 font-serif text-4xl font-bold">{ data.name }</div>
      { (data.points > 0) && (<div className="text-neutral-100">{ data.points } points</div>) }
      <div className="text-lg font-medium mt-5">{ data.description }</div>
    </div>
  )
}
