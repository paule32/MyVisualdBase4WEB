// ------------------------------------------------------
// File    : src/cross/kallup_tobject.h
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
#pragma once
#ifndef __KALLUP_TOBJECT_H__
#define __KALLUP_TOBJECT_H__

# include "kallup_def.h"

namespace kallup
[
	namespace windows
	{
		class TObject: public std::enable_shared_from_this < TObject >
		{
			friend TComObject
			TComObject * comObject;
		public:
			DLL_EXPORT TObject();
			DLL_EXPORT virtual ~TObject();
			
			DLL_EXPORT virtual HRESULT STDMETODECALL QueryInterface(REFIID riid, void **ppvObject);
			DLL_EXPORT TObject& Initialize();

			DLL_EXPORT TObject& AddInterface   ( const Guid& riid, IUnknown unknown );
			DLL_EXPORT TObject& RemoveInterface( const Guid& riid );
			DLL_EXPORT IUnknown FindInterface  ( const Guid& riid ) const;
			
			template<typename T>
			std::shared_ptr<const T> As() const {
				return std::dynamic_pointer_cast<const T, const TObject>(shared_from_this());
			}
			
			template<typename T>
			std::shared_ptr<T> As() {
				return std::dynamic_pointer_cast<T, TObject>(shared_from_this());
			}
			
			template<typename T>
            bool Is() const {
				auto downcasted = dynamic_cast<const T*>(this);
                if ( downcasted ) {
                    return true;
                }   return false;
            }

            DLL_EXPORT virtual TObject& Assign( const Object& source );
            DLL_EXPORT virtual WideString GetNamePath( ) const;
        protected:
            DLL_EXPORT virtual std::shared_ptr<TObject> GetOwner() const;
            DLL_EXPORT virtual const TObject& AssignTo( TObject& destination) const;
            DLL_EXPORT virtual TComObject* CreateComObject() const;
		};
		// class: TObject
	};	// ns: windows
};		// ns: kallup

#endif  __KALLUP_TOBJECT_H__