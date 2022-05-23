import React from 'react';

export default function Button({ processing, children }) {
  return (
    <div>
      <button
        type="submit"
        className={`inline-flex items-center px-4 py-2 bg-purple-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-purple-900 transition ease-in-out duration-150 ${processing && 'opacity-25'}`}
        disabled={ processing }
      >
        { children }
      </button>
    </div>
  )
}
