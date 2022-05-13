import React from 'react';

export default function InputGroup({ onSubmit, children }) {
  return (
    <form onSubmit={ onSubmit }>
      <div className="space-y-4">
        { children }
      </div>
    </form>
  )
}
