import React from 'react';

export default function Group({ onSubmit, children }) {
  return (
    <form onSubmit={ onSubmit }>
      <div className="space-y-4">
        { children }
      </div>
    </form>
  )
}
