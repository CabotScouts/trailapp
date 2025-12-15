import React from 'react';

export default function Checkbox(props) {
  return (
    <div>
      <div className="flex items-center">
        <input
          id={props.name}
          type="checkbox"
          className="flex-none mr-2 border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm"
          {...props}
        />
        <label htmlFor={props.name} className="flex-grow block font-medium text-sm text-slate-700">{props.label}</label>
      </div>
    </div>
  )
}
